@extends('layouts.card')

@section('card-header')
  <h2>{!! $module->elaGetIcon() !!} {{$module->elaGetTitle() }}</h2>
@endsection

@section('card-body')

    @if($module->elaAuth('postRow'))
    <button id="crudadd" type="button" class="btn btn-primary mb-3" data-elaaction="postForm" data-elamodule="{{$module}}">
      <i class="fas fa-plus-circle"></i> {{ __('Add') }}
    </button>
    @endif

    <div class="table-responsive">
    <table id="crud-table" class="table table-striped table-bordered">
      <thead>
        @foreach($module->elaColumns() as $column=>$config)
          <?php if($config->nonlistable??false) continue; ?>
          <th>{{$config->label??$column}}</th>
        @endforeach
        <th></th>
      </thead>
      <tbody>
        <?php $module->elaActionGetRows(); ?>
      </tbody>
      <tfoot>
        @foreach($module->elaColumns() as $column=>$config)
          <?php if($config->nonlistable??false) continue; ?>
          <th>{{$column}}</th>
        @endforeach
        <th></th>
      </tfoot>
    </table>
    </div>

@endsection

@push('scripts')
<script>
function redrawCrudTable(){
  elaRequest('getRows', '{{$module}}').done(function(data){
    var tbody = $('#crud-table tbody');
    tbody.html(data);
  }).fail(function(res){
    toastr.error(res.responseText);
  });
}

redrawCrudTable();
</script>
@endpush
