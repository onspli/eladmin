<div class="actions mb-3 mt-3 ">
<span class="mr-2">
@if($module->elaAuth('create'))
  <button id="crudadd" type="button" class="btn btn-success mr-1" data-elaaction="postForm">
    <i class="fas fa-plus-circle"></i> {{ __('Add') }}
  </button>
@endif

@if($module->elaImplementsFilters())
@foreach($module->elaFiltersGet() as $filter)
  <button href="#crud-filters"  class="btn btn-secondary crud-filters mr-1" data-toggle="collapse"><i class="fas fa-filter"></i> <span class="d-none d-sm-inline">{{ __('Filters') }}</span></button>
  @break
@endforeach
@endif

@if($module->elaImplementsSoftDeletes())
  <button class="btn btn-secondary crud-trash mr-1" data-toggle="collapse"><i class="fas fa-trash-restore"></i> {{ __('Trash') }}</button>
@endif
</span>

<?php
$elaActions = [];
foreach ($module->elaActionsGet() as $action) {
  if(!$module->elaAuth($action->getName())) continue;
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

@if($module->elaImplementsSoftDeletes())

@if($module->elaAuth('softDelete'))
<button type="button" class="bulk-action btn btn-danger mr-1" data-bulkconfirm="{{ __('Move to trash.') }}" data-elabulkaction="softDelete">
  <i class="fas fa-trash-alt"></i>
</button>
@endif

@if($module->elaAuth('restore'))
<button type="button" class="bulk-action-trash btn btn-success mr-1" data-bulkconfirm="{{ __('Restore items.') }}" data-elabulkaction="restore">
  <i class="fas fa-recycle"></i>
</button>
@endif

@if($module->elaAuth('delete'))
<button type="button" class="bulk-action-trash btn btn-danger mr-1" data-bulkconfirm="{{ __('Delete items.') }}" data-elabulkaction="delete">
  <i class="fas fa-trash-alt"></i>
</button>
@endif

@else

@if($module->elaAuth('delete'))
<button type="button" class="bulk-action btn btn-danger mr-1" data-bulkconfirm="{{ __('Delete items.') }}" data-elabulkaction="delete">
  <i class="fas fa-trash-alt"></i>
</button>
@endif

@endif

</div>
