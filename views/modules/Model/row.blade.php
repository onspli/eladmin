<tr>
  @foreach($module->elaColumns() as $column=>$config)
  <?php if($config->nonlistable??false) continue; ?>

    <?php
      $value = $config->listformat? ($config->listformat)($row->$column, $row, $column, $module, $eladmin):$row->$column;
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
    @section('actions')
      @foreach($module->elaActions() as $action=>$config)
        <?php
        if(!$module->elaAuth($action)) continue;
        if($config->nonlistable) continue;
        ?>

          <button data-elaaction="{{$action}}" data-eladone="redrawCrudTable();" data-elamodule="{{$module}}" data-elaarg{{$module->getKeyName()}}="{{$row->getKey()}}" class="btn m-1 btn-{{ $config->style }}">{!! $config->icon !!}
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
              data-elamodule="{{$eladmin->moduleKey()}}"
              data-elaarg{{$module->getKeyName()}}="{{$row->getKey()}}">
        <i class="fas fa-edit"></i> <span class="d-none d-lg-inline">{{ __('Edit') }}</span>
      </button>

  </td>
</tr>
