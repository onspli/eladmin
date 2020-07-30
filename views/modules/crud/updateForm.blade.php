@extends('layouts.modal')

@section('modal-title')
  {{ __('Edit entry %s', '#' . $row[$module->primary()]) }}
@endsection

@section('modal-body')
  <form id="modal-form" data-elaaction="update" data-elagetid="{{ $row[$module->primary()] }}">

  @section('form-body')
  @foreach($module->getCrudColumns() as $column)
    <?php if($column->noneditable) continue; ?>
    @component('components.inputs.'.$column->input, ['column' => $column, 'row' => $row])
    @endcomponent
  @endforeach
  @show

  </form>

@endsection

@section('modal-footer')

<?php
$elaActions = [];
foreach ($module->getCrudActions() as $action) {
  if(!$module->auth($action->getName())) continue;
  if($action->noneditable) continue;
  $elaActions[] = $action;
}
?>

@section('actions')
@if(sizeof($elaActions) || ((!$module->implementsSoftDeletes() && $module->auth('delete')) || ($module->implementsSoftDeletes() && $module->auth('softDelete'))))
<span class="dropdown actions-dropdown mr-auto">
  <button class="btn btn-primary m-1 dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i> <span class="d-none d-sm-inline">{{ __('Actions')}}</span></button>
  <div class="dropdown-menu">
  @foreach($elaActions as $action)
    <?php $actionArr = $action->getAction(); ?>
    <a href="#" data-elaupdateaction="{{$action->getName()}}"
        @if(isset($actionArr['confirm']))
        data-confirm="{{ $actionArr['confirm'] }}"
        @endif
        data-eladone="{!! htmlspecialchars($actionArr['done']) !!}"
        data-elagetid="{{ $row[$module->primary()] }}"
        class="dropdown-item text-{{ $actionArr['style'] }}">
    {!! $actionArr['icon'] !!} {{ $actionArr['label'] }}
    </a>
  @endforeach
  @if(!$module->implementsSoftDeletes() && $module->auth('delete'))
  <a href="#" type="button" class="dropdown-item text-danger" data-elaaction="delete" data-elagetid="{{ $row[$module->primary()] }}" data-eladone="modalClose();" data-confirm="{{__('Are you sure?')}}"><i class="fas fa-trash-alt"></i> <span class="d-none d-sm-inline">{{ __('Delete')}}</span></a>
  @elseif($module->implementsSoftDeletes() && $module->auth('softDelete'))
  <a href="#" type="button" class="dropdown-item text-danger" data-elaaction="softDelete" data-elagetid="{{ $row[$module->primary()] }}" data-eladone="modalClose();"><i class="fas fa-trash-alt"></i> <span class="d-none d-sm-inline">{{ __('Move to trash')}}</span></a>
  @endif
  </div>
</span>
@endif
@show

  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> <span class="">{{__('Cancel')}}</span></button>
  @if($module->auth('update'))
  <button type="submit" form="modal-form" class="btn btn-primary"><i class="fas fa-save"></i> <span class="">{{__('Save')}}</span></button>
  @endif
@endsection
