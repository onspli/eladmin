@extends('layouts.modal')

@section('modal-title')
  {{ __('Create new entry')}}
@endsection

@section('modal-body')
  <form id="modal-form" data-elaaction="create">
    @foreach($module->elaColumnsGet() as $column)
      <?php if ($column->noneditable) continue; ?>
      @component('components.inputs.'.$column->input, ['column' => $column, 'row' => $row])
      @endcomponent
    @endforeach
  </form>
@endsection

@section('modal-footer')
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> {{__('Cancel')}}</button>
  <button type="submit" form="modal-form" class="btn btn-primary"><i class="fas fa-save"></i> {{__('Create')}}</button>
@endsection
