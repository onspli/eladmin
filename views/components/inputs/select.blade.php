<div class="form-group">
  <label>{{$config->label?$config->label:$column}}</label>
  <select class="form-control" {!! ($config->disabled?' disabled="disabled" ':' name="'.$column.'" ') !!}>
    @foreach($config->selectOptions as $value=>$label)
      <option value="{{$value}}" {!! ($row->$column??null)===$value?' selected="selected" ':''  !!}>{{ $label }}</option>
    @endforeach
  </select>
  @if($config->desc)
  <small class="form-text text-muted">{!! $config->desc !!}</small>
  @endif
</div>
