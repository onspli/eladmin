<div id="crud-filters" class="form-inline collapse">
@foreach($module->elaFiltersGet() as $name => $filter)
  <div class="input-group mr-2 mb-3">
    <div class="input-group-prepend"><label class="input-group-text">{!! $filter->icon !!}&nbsp;{{$filter->label??$name}}</label></div>
    @if($filter->input == 'select')
    <select class="form-control" data-crudfilter="{{$filter->column??$name}}">
      <?php
      if(is_callable($filter->selectOptions)) {
        $selectOptions = ($filter->selectOptions)($filter, $name);
      } else {
        $selectOptions = $filter->selectOptions;
      }
      ?>
      @foreach($selectOptions as $value => $label)
      <option value="{{$value}}">{{ $label }}</option>
      @endforeach
    </select>
    @else
      <input type="text" class="form-control" data-crudfilter="{{$filter->column??$name}}">
    @endif
  </div>
@endforeach
</div>
