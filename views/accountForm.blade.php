@extends('components.modal')

@section('modal-title')
 {{ __('Account')}} <strong>{{$eladmin->username()}}</strong>
@endsection

@section('modal-body')
  <form id="modal-form" action="{{ $eladmin->request('account','') }}">
      @foreach($eladmin->accountFields() as $column=>$config)
        <div class="form-group">
            <label>{{$config['label']??$column}}</label>
            <input type="{{ $config['type']??'text' }}" class="form-control" name="{{$column}}">
        </div>
      @endforeach
  </form>
@endsection

@section('modal-footer')
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> {{__('Cancel')}}</button>
  <button type="submit" form="modal-form" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Save') }}</button>
@endsection
