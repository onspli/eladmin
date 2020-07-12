<div class="form-group">
  <label>{{$column->label?$column->label:$column->getName()}}</label>
  <select class="form-control" {!! ($column->disabled?' disabled="disabled" ':' name="'.$column->getName().'" ') !!}>
    <?php
    $selectOptions = $column->evalProperty('selectOptions', $row);
    $value = $column->getValue($row, true);
    ?>
    @foreach($selectOptions as $val=>$label)
      <option value="{{$val}}" {!! $val == $value ? ' selected="selected" ' : '' !!}>{{ $label }}</option>
    @endforeach
  </select>
  @if($column->desc)
  <small class="form-text text-muted">{!! $column->desc !!}</small>
  @endif
</div>
