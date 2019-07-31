<tr>
  @foreach($module->elaColumns() as $column=>$config)
  <?php if($config->nonlistable??false) continue; ?>

    <?php
      $value = $config->listformat? ($config->listformat)($row->$column, $row, $column, $module, $eladmin):$row->$column;
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

    @if($module->elaAuth('restore'))
    <button class="btn m-1 btn-success"
            data-elaaction="restore"
            data-elamodule="{{$module->elakey()}}"
            data-eladone="redrawCrudTable();"
            data-elaarg{{$module->getKeyName()}}="{{$row->getKey()}}"
             title="{{ __('Restore') }}">
      <i class="fas fa-recycle"></i>
    </button>
    @endif

    @if($module->elaAuth('forceDelete'))
    <button class="btn m-1 btn-danger"
            data-elaaction="forceDelete"
            data-elamodule="{{$module->elakey()}}"
            data-eladone="redrawCrudTable();"
            data-confirm="{{__('Are you sure?')}}"
            data-elaarg{{$module->getKeyName()}}="{{$row->getKey()}}"
            title="{{ __('Delete') }}">
      <i class="fas fa-trash-alt"></i>
    </button>
    @endif

    @else
    @section('actions')
      @foreach($module->elaActions() as $action=>$config)
        <?php
        if(!$module->elaAuth($action)) continue;
        if($config->nonlistable) continue;
        if(is_callable($config->label))
          $value = ($config->label)($row->$column, $row, $column, $module, $eladmin);
        else $value = $config->label??$action;
        ?>

          <button data-elaaction="{{$action}}" data-eladone="redrawCrudTable();"
          @if($config->confirm !== null)
            data-confirm="{{$config->confirm?$config->confirm:$value}}"
          @endif
           data-elamodule="{{$module->elakey()}}" data-elaarg{{$module->getKeyName()}}="{{$row->getKey()}}" class="btn m-1 btn-{{ $config->style }}">{!! $config->icon !!}
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

      @if($module->elaAuth('update'))
      <button class="btn m-1 btn-primary"
              data-elaaction="putForm"
              data-elamodule="{{$module->elakey()}}"
              data-elaarg{{$module->getKeyName()}}="{{$row->getKey()}}"
               title="{{ __('Edit') }}" >
        <i class="fas fa-edit"></i>
      </button>
      @elseif($module->elaAuth('read'))
      <button class="btn m-1 btn-primary"
              data-elaaction="putForm"
              data-elamodule="{{$module->elakey()}}"
              data-elaarg{{$module->getKeyName()}}="{{$row->getKey()}}"
               title="{{ __('Edit') }}" >
        <i class="fas fa-eye"></i>
      </button>
      @endif


      @if($module->elaUsesSoftDeletes() && $module->elaAuth('delete'))
      <button class="btn m-1 btn-danger"
              data-elaaction="delete"
              data-elamodule="{{$module->elakey()}}"
              data-eladone="redrawCrudTable();"
              data-elaarg{{$module->getKeyName()}}="{{$row->getKey()}}"
               title="{{ __('Delete') }}" >
        <i class="fas fa-trash-alt"></i>
      </button>
      @endif

    @endif

  </td>
</tr>
