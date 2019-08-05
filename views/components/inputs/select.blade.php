<div class="form-group">
  <label>{{$config->label?$config->label:$column}}</label>
  <select class="form-control" {!! ($config->disabled?' disabled="disabled" ':' name="'.$column.'" ') !!}>
    <?php
    if(is_callable($config->selectOptions)){
      $selectOptions = ($config->selectOptions)($value, $row, $column, $module, $eladmin);
    } else{
      $selectOptions = $config->selectOptions;
    }
    ?>
    @foreach($selectOptions as $val=>$label)
      <option value="{{$val}}" {!! $val==$value?' selected="selected" ':''  !!}>{{ $label }}</option>
    @endforeach
  </select>
  @if($config->desc)
  <small class="form-text text-muted">{!! $config->desc !!}</small>
  @endif
</div>
