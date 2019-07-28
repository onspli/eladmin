@extends('layouts.modal')

@section('modal-title')
  {{__('Edit entry %s', '#'.$row->getKey()) }}
@endsection

@section('modal-body')
  @if($module->elaAuth('putRow'))
  <form id="modal-form" data-eladone="redrawCrudTable();" action="{{ $module->elaRequest('putRow') }}">
  @endif

    @section('form-body')
    <input type="hidden" name="{{$module->getKeyName()}}" value="{{$row->getKey()}}">
    @foreach($module->elaColumns() as $column=>$config)
      <?php if($config->noneditable) continue; ?>
      @component('components.inputs.'.$config->input, ['column'=>$column, 'config'=>$config, 'module'=>$module, 'row'=>$row, 'eladmin'=>$eladmin])
      @endcomponent

    @endforeach
    @show

  @if($module->elaAuth('putRow'))
  </form>
  @endif

  @section('actions')
    @foreach($module->elaActions() as $action=>$config)
      <?php
      if(!$module->elaAuth($action)) continue;
      if($config->noneditable) continue;
      ?>
      <div class="form-group">
        <button data-elaaction="{{$action}}" data-elamodule="{{$module}}" data-eladone="$('#dynamic .modal').modal('hide'); redrawCrudTable();" data-elaarg{{$module->getKeyName()}}="{{$row->getKey()}}" class="btn btn-{{ $config->style }}">{!! $config->icon !!} {{ $config->label??$action }}</button>
      </div>
    @endforeach
  @show

@endsection

@section('modal-footer')
  @if($module->elaAuth('delRow'))
  <button type="button" class="btn btn-danger mr-3" data-elaaction="delRow" data-elamodule="{{$module}}" data-elaarg{{$module->getKeyName()}}="{{$row->getKey()}}" data-eladone="$('#dynamic .modal').modal('hide');redrawCrudTable();" data-confirm="Opravdu smazat?"><i class="fas fa-trash-alt"></i> <span class="d-none d-sm-inline">{{ __('Delete')}}</span></button>
  @endif
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> <span class="">{{__('Cancel')}}</span></button>
  @if($module->elaAuth('putRow'))
    <button type="submit" form="modal-form" class="btn btn-primary"><i class="fas fa-save"></i> <span class="">{{__('Save')}}</span></button>
  @endif
@endsection
