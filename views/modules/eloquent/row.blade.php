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

    @if($module->elaAuth('restoreRow'))
    <button class="btn m-1 btn-success"
            data-elaaction="restoreRow"
            data-elamodule="{{$module->elakey()}}"
            data-eladone="redrawCrudTable();"
            data-elaarg{{$module->getKeyName()}}="{{$row->getKey()}}"
             title="{{ __('Restore') }}">
      <i class="fas fa-recycle"></i>
    </button>
    @endif

    @if($module->elaAuth('forceDelRow'))
    <button class="btn m-1 btn-danger"
            data-elaaction="forceDelRow"
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
        ?>

          <button data-elaaction="{{$action}}" data-eladone="redrawCrudTable();" data-elamodule="{{$module->elakey()}}" data-elaarg{{$module->getKeyName()}}="{{$row->getKey()}}" class="btn m-1 btn-{{ $config->style }}">{!! $config->icon !!}
            @if(isset($config->icon))
            <span class="d-none d-lg-inline">
            @endif
            {{ $config->label??$action }}
            @if(isset($config->icon))
          </span>
            @endif
          </button>

      @endforeach
    @show


      <button class="btn m-1 btn-primary"
              data-elaaction="putForm"
              data-elamodule="{{$module->elakey()}}"
              data-elaarg{{$module->getKeyName()}}="{{$row->getKey()}}"
               title="{{ __('Edit') }}" >
        <i class="fas fa-edit"></i>
      </button>


      @if($module->elaUsesSoftDeletes() && $module->elaAuth('delRow'))
      <button class="btn m-1 btn-danger"
              data-elaaction="delRow"
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
