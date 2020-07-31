<div class="form-group">
  <label>{{$column->label?$column->label:$column->getName()}}</label>
  <input type="password" value="{{ $column->getValue($row, true) }}" class="form-control" {!! ($column->disabled?' disabled="disabled" ':' name="'.$column->getName().'" ') !!}>
  @if($column->desc)
  <small class="form-text text-muted">{!! $column->desc !!}</small>
  @endif
</div>
