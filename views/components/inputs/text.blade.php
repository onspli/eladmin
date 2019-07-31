<div class="form-group">
  <label>{{$config->label?$config->label:$column}}</label>
  <input type="text" value="{{$value}}" class="form-control" {!! ($config->disabled?' disabled="disabled" ':' name="'.$column.'" ') !!}>
  @if($config->desc)
  <small class="form-text text-muted">{!! $config->desc !!}</small>
  @endif
</div>
