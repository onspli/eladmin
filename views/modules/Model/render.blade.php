@extends('components.card')

@section('card-header')
  <h2>{!! $elaModule->elaGetIcon() !!} {{$elaModule->elaGetTitle() }}</h2>
@endsection

@section('card-body')

    @if($eladmin->auth('postRow'))
    <button id="crudadd" type="button" class="btn btn-primary mb-3" data-elaaction="postForm">
      <i class="fas fa-plus-circle"></i> Přidat
    </button>
    @endif

    <div class="table-responsive">
    <table id="crud-table" class="table table-striped table-bordered">

      <thead>
        @foreach($elaModule->elaColumns() as $column=>$config)
          <?php if($config->nonlistable??false) continue; ?>
          <th>{{$config->label??$column}}</th>
        @endforeach
        <th></th>
      </thead>
      <tbody>
        <?php $elaModule->elaActionGetRows(); ?>
      </tbody>
      <tfoot>
        @foreach($elaModule->elaColumns() as $column=>$config)
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
  elaRequest('getRows', null).done(function(data){
    var tbody = $('#crud-table tbody');
    tbody.html(data);
  }).fail(function(res){
    toastr.error(res.responseText);
  });
}

redrawCrudTable();
</script>
@endpush
