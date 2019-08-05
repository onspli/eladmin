@extends('layouts.modal')

@section('modal-title')
  {{ __('Create new entry')}}
@endsection

@section('modal-body')
  <form id="modal-form" data-elaaction="create" data-elamodule="{{$module->elakey()}}">
    @foreach($module->elaColumns() as $column=>$config)
      <?php
      //if($column == $module->getKeyName()) continue;
      if($config->noneditable??false) continue;
      ?>
      @component('components.inputs.'.$config->input, ['value'=>'', 'column'=>$column, 'config'=>$config, 'module'=>$module, 'row'=>new \StdClass, 'eladmin'=>$eladmin])
      @endcomponent

    @endforeach
  </form>
@endsection

@section('modal-footer')
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> {{__('Cancel')}}</button>
  <button type="submit" form="modal-form" class="btn btn-primary"><i class="fas fa-save"></i> {{__('Create')}}</button>
@endsection
