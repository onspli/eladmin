<div class="form-group">
  <label>{{$config->label?$config->label:$column}}</label>
  <select class="form-control" {!! ($config->disabled?' disabled="disabled" ':' name="'.$column.'" ') !!}>
    <?php
    $options = $config->selectFromModel::all();
    ?>
    @foreach($options as $option)
      <option value="{{$option->getKey() }}" {!! ($row->$column??null)===$option->getKey()?' selected="selected" ':''  !!}>{{ $option->{$config->selectFromModelDesc} }}</option>
    @endforeach
  </select>
  @if($config->desc)
  <small class="form-text text-muted">{!! $config->desc !!}</small>
  @endif
</div>
