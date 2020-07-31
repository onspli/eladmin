<div class="actions mb-3 mt-3 ">
<span class="mr-2">
@if($module->auth('create') && isset($module->getCrudActions()->create))
  <button id="crudadd" type="button" class="btn btn-success mr-1" data-elaaction="createForm">
    {!! $module->getCrudActions()->create->icon !!} {{ $module->getCrudActions()->create->label }}
  </button>
@endif

@if($module->implementsFilters())
@foreach($module->getCrudFilters() as $filter)
  <button href="#crud-filters"  class="btn btn-secondary crud-filters mr-1" data-toggle="collapse"><i class="fas fa-filter"></i> <span class="d-none d-sm-inline">{{ __('Filters') }}</span></button>
  @break
@endforeach
@endif

@if($module->implementsSoftDeletes())
  <button class="btn btn-secondary crud-trash mr-1" data-toggle="collapse"><i class="fas fa-trash-restore"></i> {{ __('Trash') }}</button>
@endif
</span>

<?php
$elaActions = [];
foreach ($module->getCrudActions() as $action) {
  if(!$module->auth($action->getName())) continue;
  if(!$action->bulk || in_array($action->getName(), ['restore', 'delete', 'softdelete'])) continue;
  $elaActions[] = $action;
}
?>

@if(sizeof($elaActions))
<span class="dropdown actions-dropdown bulk-action">
  <button class="btn btn-primary mr-1 dropdown-toggle bulk-action" type="button" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i> {{ __('Actions')}}</button>
  <div class="dropdown-menu">
  @foreach($elaActions as $action)
    <?php $actionArr = $action->getAction(); ?>
    <a href="#" data-elabulkaction="{{$action->getName()}}"
        @if($action->form)
        data-formaction="true"
        @endif
        @if(isset($actionArr['confirm']))
        data-bulkconfirm="{{ $actionArr['confirm'] }}"
        @else
        data-bulkconfirm="{{ $actionArr['label'] }}"
        @endif
        data-eladone="{!! htmlspecialchars($actionArr['done']) !!}"
        class="dropdown-item text-{{ $actionArr['style'] }}">
    {!! $actionArr['icon'] !!} {{ $actionArr['label'] }}
    </a>
  @endforeach
  </div>
</span>
@endif

@if($module->implementsSoftDeletes())

@if($module->auth('softDelete') && isset($module->getCrudActions()->softDelete) && $module->getCrudActions()->softDelete->bulk)
<button type="button" class="bulk-action btn btn-danger mr-1" data-bulkconfirm="{{ __('Move to trash.') }}" data-elabulkaction="softDelete">
  <i class="fas fa-trash-alt"></i>
</button>
@endif

@if($module->auth('restore') && isset($module->getCrudActions()->restore) && $module->getCrudActions()->restore->bulk)
<button type="button" class="bulk-action-trash btn btn-success mr-1" data-bulkconfirm="{{ __('Restore items.') }}" data-elabulkaction="restore">
  <i class="fas fa-recycle"></i>
</button>
@endif

@if($module->auth('delete') && isset($module->getCrudActions()->delete) && $module->getCrudActions()->delete->bulk)
<button type="button" class="bulk-action-trash btn btn-danger mr-1" data-bulkconfirm="{{ __('Delete items.') }}" data-elabulkaction="delete">
  <i class="fas fa-trash-alt"></i>
</button>
@endif

@else

@if($module->auth('delete') && isset($module->getCrudActions()->delete) && $module->getCrudActions()->delete->bulk)
<button type="button" class="bulk-action btn btn-danger mr-1" data-bulkconfirm="{{ __('Delete items.') }}" data-elabulkaction="delete">
  <i class="fas fa-trash-alt"></i>
</button>
@endif

@endif

</div>
