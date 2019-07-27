<div class="form-group">
  <label>{{$config->label?$config->label:$column}}</label>
  <textarea class="form-control" rows="5" {!! ($config->disabled?' disabled="disabled" ':' name="'.$column.'" ') !!}>{{ $row->$column??'' }}</textarea>
  @if($config->desc)
  <small class="form-text text-muted">{!! $config->desc !!}</small>
  @endif
</div>
