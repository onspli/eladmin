<tr>
  @foreach($row->elaColumns() as $column=>$config)
  <?php if($config->nonlistable??false) continue; ?>

    <?php
      if($config->getformat){
        $value = ($config->getformat)($row->$column, $row, $column);
      } else{
        $value = $row->$column;
      }
      $value = $config->listformat? ($config->listformat)($value, $row, $column):$value;

    ?>

    <?php
    if($config->listformat == false && $value instanceof \Illuminate\Database\Eloquent\Model){
      if($value->elaRepresentativeColumn){
        $value = $value->{$value->elaRepresentativeColumn};
      } else{
        $value = $value->getKey();
      }
    }
    ?>

    @if($config->rawoutput)
      <td>
        {!! $value !!}
      </td>
    @else
      <td title="{{$value}}">
      {{ str_limit($value, $config->listlimit, '...') }}
      </td>
    @endif

  @endforeach
  <td class="text-right">
    @if($trash)

    @if($row->elaAuth('restore'))
    <button class="btn m-1 btn-success"
            data-elaaction="restore"
            data-elamodule="{{$row->elakey()}}"
            data-eladone="redrawCrudTable();"
            data-elaarg{{$row->getKeyName()}}="{{$row->getKey()}}"
             title="{{ __('Restore') }}">
      <i class="fas fa-recycle"></i>
    </button>
    @endif

    @if($row->elaAuth('forceDelete'))
    <button class="btn m-1 btn-danger"
            data-elaaction="forceDelete"
            data-elamodule="{{$row->elakey()}}"
            data-eladone="redrawCrudTable();"
            data-confirm="{{__('Are you sure?')}}"
            data-elaarg{{$row->getKeyName()}}="{{$row->getKey()}}"
            title="{{ __('Delete') }}">
      <i class="fas fa-trash-alt"></i>
    </button>
    @endif

    @else
    @section('actions')
      @foreach($row->elaActions() as $action=>$config)
        <?php
        if(!$row->elaAuth($action)) continue;
        if($config->nonlistable) continue;
        if(is_callable($config->label))
          $value = ($config->label)($row->$column, $row, $column);
        else $value = $config->label??$action;
        ?>


          <button data-elaaction="{{$action}}" data-eladone="{!! htmlspecialchars($config->done) !!};redrawCrudTable();"
          @if($config->confirm !== null)
            data-confirm="{{$config->confirm?$config->confirm:$value}}"
          @endif
           data-elamodule="{{$row->elakey()}}" data-elaarg{{$row->getKeyName()}}="{{$row->getKey()}}" class="btn m-1 btn-{{ $config->style }}">{!! $config->icon !!}
            @if(isset($config->icon))
            <span class="d-none d-lg-inline">
            @endif
            {{ $value }}
            @if(isset($config->icon))
          </span>
            @endif
          </button>


      @endforeach
    @show

      @if($row->elaAuth('update'))
      <button class="btn m-1 btn-primary"
              data-elaaction="putForm"
              data-eladone="return;"
              data-elamodule="{{$row->elakey()}}"
              data-elaarg{{$row->getKeyName()}}="{{$row->getKey()}}"
               title="{{ __('Edit') }}" >
        <i class="fas fa-edit"></i>
      </button>
      @elseif($row->elaAuth('read'))
      <button class="btn m-1 btn-primary"
              data-elaaction="putForm"
              data-elamodule="{{$row->elakey()}}"
              data-eladone="return;"
              data-elaarg{{$row->getKeyName()}}="{{$row->getKey()}}"
               title="{{ __('Edit') }}" >
        <i class="fas fa-eye"></i>
      </button>
      @endif


      @if($row->elaUsesSoftDeletes() && $row->elaAuth('delete'))
      <button class="btn m-1 btn-danger"
              data-elaaction="delete"
              data-elamodule="{{$row->elakey()}}"
              data-eladone="redrawCrudTable();"
              data-elaarg{{$row->getKeyName()}}="{{$row->getKey()}}"
               title="{{ __('Delete') }}" >
        <i class="fas fa-trash-alt"></i>
      </button>
      @endif

    @endif

  </td>
</tr>
