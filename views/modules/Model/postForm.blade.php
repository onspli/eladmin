@extends('components.modal')

@section('modal-title')
  Přidat záznam
@endsection

@section('modal-body')
  <form id="modal-form" data-eladone="redrawCrudTable();" action="{{ $eladmin->request('postRow') }}">
    @foreach($elaModule->elaColumns() as $column=>$config)
      <?php
      if($column == $elaModule->getKeyName()) continue;
      if($config->noneditable??false) continue;
      ?>

      <div class="form-group">
        <label>{{$config->label??$column}}</label>
        <input type="text" class="form-control" {!! (($config->disabled??false)?' disabled="disabled" ':' name="'.$column.'" ') !!}>
        @if(isset($config->desc))
        <small class="form-text text-muted">{!! $config->desc !!}</small>
        @endif
      </div>
    @endforeach
  </form>
@endsection

@section('modal-footer')
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> Zrušit</button>
  <button type="submit" form="modal-form" class="btn btn-primary"><i class="fas fa-save"></i> Přidat</button>
@endsection
