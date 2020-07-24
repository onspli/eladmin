<div class="actions mb-3 mt-3 ">
@if($module->elaAuth('create'))
  <button id="crudadd" type="button" class="btn btn-success" data-elaaction="postForm" data-elamodule="{{$module->elakey()}}" data-eladone="return;">
    <i class="fas fa-plus-circle"></i> {{ __('Add') }}
  </button>
@endif
@foreach($module->elaFilters() as $filter)
  <button href="#crud-filters"  class="btn btn-primary" data-toggle="collapse"><i class="fas fa-filter"></i> {{ __('Filters') }}</button>
  @break
@endforeach
@if($module->elaUsesSoftDeletes())
  <button class="btn btn-secondary crud-trash" data-toggle="collapse"><i class="fas fa-trash-restore"></i> {{ __('Trash') }}</button>
@endif

@foreach($module->elaActions() as $action)
<?php
if(!$module->elaAuth($action->getName())) continue;
if($action->bulk === null) continue;
?>
<button type="button" data-elabulkaction="{{$action->getName()}}"
  data-elamodule="{{ $module->elakey() }}"
  data-eladone="{!! htmlspecialchars($action->done) !!};redrawCrudTable();"
  data-bulkconfirm="{{ $action->bulk }}"
  class="btn bulk-action btn-{{ $action->style }}">
  {!! $action->icon !!} {{ $action->bulk }}
 </button>
@endforeach

@if($module->elaAuth('delete'))
<button type="button" class="bulk-action btn btn-danger" data-bulkconfirm="{{ __('Delete items.') }}" data-elabulkaction="delete" data-elamodule="{{$module->elakey()}}" data-eladone="redrawCrudTable();bulkUncheckAll();">
  <i class="fas fa-trash-alt"></i>
</button>
@endif

@if($module->elaAuth('restore'))
<button type="button" class="bulk-action-trash btn btn-success" data-bulkconfirm="{{ __('Restore items.') }}" data-elabulkaction="restore" data-elamodule="{{$module->elakey()}}" data-eladone="redrawCrudTable();bulkUncheckAll();">
  <i class="fas fa-recycle"></i>
</button>
@endif

@if($module->elaAuth('forceDelete'))
<button type="button" class="bulk-action-trash btn btn-danger" data-bulkconfirm="{{ __('Delete items forever.') }}" data-elabulkaction="forceDelete" data-elamodule="{{$module->elakey()}}" data-eladone="redrawCrudTable();bulkUncheckAll();">
  <i class="fas fa-trash-alt"></i>
</button>
@endif

</div>
