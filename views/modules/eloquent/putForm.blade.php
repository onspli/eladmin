@extends('layouts.modal')

@section('modal-title')
  {{__('Edit entry %s', '#'.$row->getKey()) }}
@endsection

@section('modal-body')
  <form id="modal-form" data-elaaction="update" data-elaid="{{$row->getKey()}}" data-elamodule="{{$row->elakey()}}">


    @section('form-body')
    @foreach($row->elaColumns() as $column=>$config)
      <?php if($config->noneditable) continue; ?>
      <?php
        if($config->getformat){
          $value = ($config->getformat)($row->$column, $row, $column);
        } else{
          $value = $row->$column;
        }
        if(!$config->realcolumn){
          $value = $config->listformat? ($config->listformat)($value, $row, $column):$value;
        }
      ?>
      @component('components.inputs.'.$config->input, ['value'=>$value, 'column'=>$column, 'config'=>$config, 'module'=>$row, 'row'=>$row, 'eladmin'=>$eladmin])
      @endcomponent

    @endforeach
    @show



  @section('actions')
    @foreach($row->elaActions() as $action=>$config)
      <?php
      if(!$row->elaAuth($action)) continue;
      if($config->noneditable) continue;
      if(is_callable($config->label))
        $value = ($config->label)($row->$column, $row, $column, $row, $eladmin);
      else $value = $config->label??$action;
      ?>
      <div class="form-group">

        <button type="button" data-elaupdateaction="{{$action}}"
          @if($config->confirm !== null)
            data-confirm="{{$config->confirm?$config->confirm:$value}}"
          @endif
          data-elamodule="{{$row->elakey()}}"
          data-eladone="{!! htmlspecialchars($config->done) !!}"
          data-elaid="{{$row->getKey()}}"
          class="btn btn-{{ $config->style }}">
         {!! $config->icon !!} {{ $value }}
       </button>

      </div>
    @endforeach
  @show

  </form>

@endsection

@section('modal-footer')
  @if($row->elaAuth('delete'))
  <button type="button" class="btn btn-danger mr-3" data-elaaction="delete" data-elamodule="{{$row->elakey()}}" data-elaid="{{$row->getKey()}}" data-eladone="$('#dynamic .modal').modal('hide');" <?php if(!$row->elaUsesSoftDeletes()): ?> data-confirm="{{__('Are you sure?')}}" <?php endif; ?>><i class="fas fa-trash-alt"></i> <span class="d-none d-sm-inline">{{ __('Delete')}}</span></button>
  @endif
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> <span class="">{{__('Cancel')}}</span></button>
  @if($row->elaAuth('update'))
    <button type="submit" form="modal-form" class="btn btn-primary"><i class="fas fa-save"></i> <span class="">{{__('Save')}}</span></button>
  @endif
@endsection
