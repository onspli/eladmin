@extends('components.modal')

@section('modal-title')
  {{__('Edit entry %s', '#'.$row->getKey()) }}
@endsection

@section('modal-body')
  @if($eladmin->auth('putRow'))
  <form id="modal-form" data-eladone="redrawCrudTable();" action="{{ $eladmin->request('putRow') }}">
  @endif

    @section('form-body')
    <input type="hidden" name="{{$elaModule->getKeyName()}}" value="{{$row->getKey()}}">
    @foreach($elaModule->elaColumns() as $column=>$config)
      <?php if($config->noneditable) continue; ?>
      <div class="form-group">
        <label>{{$config->label?$config->label:$column}}</label>
        <input type="text" value="{{$row->$column}}" class="form-control" {!! ($config->disabled?' disabled="disabled" ':' name="'.$column.'" ') !!}>
        @if($config->desc)
        <small class="form-text text-muted">{!! $config->desc !!}</small>
        @endif
      </div>
    @endforeach
    @show

  @if($eladmin->auth('putRow'))
  </form>
  @endif

  @section('actions')
    @foreach($elaModule->elaActions() as $action=>$config)
      <?php
      if(!$eladmin->auth($action)) continue;
      if($config->noneditable) continue;
      ?>
      <div class="form-group">
        <button data-elaaction="{{$action}}" data-eladon="redrawCrudTable();" data-elaarg{{$elaModule->getKeyName()}}="{{$row->getKey()}}" class="btn btn-{{ $config->style }}">{!! $config->icon !!} {{ $config->label??$action }}</button>
      </div>
    @endforeach
  @show

@endsection

@section('modal-footer')
  @if($eladmin->auth('delRow'))
  <button type="button" class="btn btn-danger mr-3" data-elaaction="delRow" data-elaarg{{$elaModule->getKeyName()}}="{{$row->getKey()}}" data-eladone="$('#dynamic .modal').modal('hide');redrawCrudTable();" data-confirm="Opravdu smazat?"><i class="fas fa-trash-alt"></i> <span class="d-none d-sm-inline">{{ __('Delete')}}</span></button>
  @endif
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> <span class="">{{__('Cancel')}}</span></button>
  @if($eladmin->auth('putRow'))
    <button type="submit" form="modal-form" class="btn btn-primary"><i class="fas fa-save"></i> <span class="">{{__('Save')}}</span></button>
  @endif
@endsection
