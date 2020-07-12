<div class="form-group">
  <label>{{$column->label?$column->label:$column->getName()}}</label>
  <textarea class="form-control" rows="5" {!! ($column->disabled?' disabled="disabled" ':' name="'.$column->getName().'" ') !!}>{{ $column->getValue($row, true) }}</textarea>
  @if($column->desc)
  <small class="form-text text-muted">{!! $column->desc !!}</small>
  @endif
</div>
