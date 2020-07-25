@extends('layouts.modal')

@section('modal-title')
  {{ __('Edit entry %s', '#' . $row[$module->elaPrimary()]) }}
@endsection

@section('modal-body')
  <form id="modal-form" data-elaaction="update" data-elaid="{{ $row[$module->elaPrimary()] }}" data-elamodule="{{ $module->elakey() }}">

  @section('form-body')
  @foreach($module->elaColumns() as $column)
    <?php if($column->noneditable) continue; ?>
    @component('components.inputs.'.$column->input, ['column' => $column, 'row' => $row])
    @endcomponent
  @endforeach
  @show

  @section('actions')
    @foreach($module->elaActions() as $action)
      <?php
      if(!$module->elaAuth($action->getName())) continue;
      if($action->noneditable) continue;
      $actionArr = $action->getAction($row);
      ?>
      <div class="form-group">
        <button type="button" data-elaupdateaction="{{$action->getName()}}"
          @if(isset($actionArr['confirm']))
          data-elaconfirm="{{ $actionArr['confirm'] }}"
          @endif
          data-elamodule="{{ $actionArr['module'] }}"
          data-eladone="{!! htmlspecialchars($actionArr['done']) !!}"
          data-elaid="{{ $actionArr['id'] }}"
          class="btn btn-{{ $actionArr['style'] }}">
          {!! $actionArr['icon'] !!} {{ $actionArr['label'] }}
       </button>
      </div>
    @endforeach
  @show

  </form>

@endsection

@section('modal-footer')
  @if(!$module->elaUsesSoftDeletes() && $module->elaAuth('delete'))
  <button type="button" class="btn btn-danger mr-3" data-elaaction="delete" data-elamodule="{{ $module->elakey() }}" data-elaid="{{ $row[$module->elaPrimary()] }}" data-eladone="$('#dynamic .modal').modal('hide');" data-confirm="{{__('Are you sure?')}}"><i class="fas fa-trash-alt"></i> <span class="d-none d-sm-inline">{{ __('Delete')}}</span></button>
  @elseif($module->elaUsesSoftDeletes() && $module->elaAuth('softDelete'))
  <button type="button" class="btn btn-danger mr-3" data-elaaction="softDelete" data-elamodule="{{ $module->elakey() }}" data-elaid="{{ $row[$module->elaPrimary()] }}" data-eladone="$('#dynamic .modal').modal('hide');"><i class="fas fa-trash-alt"></i> <span class="d-none d-sm-inline">{{ __('Delete')}}</span></button>
  @endif
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> <span class="">{{__('Cancel')}}</span></button>
  @if($module->elaAuth('update'))
    <button type="submit" form="modal-form" class="btn btn-primary"><i class="fas fa-save"></i> <span class="">{{__('Save')}}</span></button>
  @endif
@endsection
