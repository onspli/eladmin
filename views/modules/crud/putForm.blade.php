@extends('layouts.modal')

@section('modal-title')
  {{ __('Edit entry %s', '#'.$row->getKey()) }}
@endsection

@section('modal-body')
  <form id="modal-form" data-elaaction="update" data-elaid="{{$row->getKey()}}" data-elamodule="{{$row->elakey()}}">

  @section('form-body')
  @foreach($row->elaColumns() as $column)
    <?php if($column->noneditable) continue; ?>
    @component('components.inputs.'.$column->input, ['column'=>$column, 'row'=>$row])
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
  @if($module->elaAuth('delete'))
  <button type="button" class="btn btn-danger mr-3" data-elaaction="delete" data-elamodule="{{$row->elakey()}}" data-elaid="{{$row->getKey()}}" data-eladone="$('#dynamic .modal').modal('hide');" <?php if(!$row->elaUsesSoftDeletes()): ?> data-elaconfirm="{{__('Are you sure?')}}" <?php endif; ?>><i class="fas fa-trash-alt"></i> <span class="d-none d-sm-inline">{{ __('Delete')}}</span></button>
  @endif
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> <span class="">{{__('Cancel')}}</span></button>
  @if($module->elaAuth('update'))
    <button type="submit" form="modal-form" class="btn btn-primary"><i class="fas fa-save"></i> <span class="">{{__('Save')}}</span></button>
  @endif
@endsection
