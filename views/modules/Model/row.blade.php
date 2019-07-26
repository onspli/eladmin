<tr>
  @foreach($elaModule->elaColumns() as $column=>$config)
  <?php if($config->nonlistable??false) continue; ?>
  <td>
    @if($config->rawoutput??false)
      {!! $row->$column !!}
    @else
      {{$row->$column}}
    @endif
  </td>
  @endforeach
  <td class="text-right">
      <button class="btn btn-primary"
              data-elaaction="putForm"
              data-elaarg{{$elaModule->getKeyName()}}="{{$row->getKey()}}">
        <i class="fas fa-edit"></i>
      </button>
  </td>
</tr>
