<div class="actions mb-3 ">
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
</div>
