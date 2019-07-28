@extends('layouts.card')

@section('card-header')
  <h2>{!! $module->elaGetIcon() !!} {{$module->elaGetTitle() }}</h2>
@endsection

@section('card-body')

  <style>
  #crud-table td {
    white-space: nowrap;
    vertical-align: middle;
  }
  #crud-table th {
    position: relative;
    padding-right: 2em;
  }

  #crud-table th i.fas{
    position: absolute;
    right: 0.5em;
    top: 1em;
  }

  .crud-paging.form-inline .form-control{
    display: inline-block !important;
    width: auto!important
  }
  .crud-paging.form-inline .input-group{
    width: auto!important;

  }


  </style>

    <div class="actions mb-3 d-inline-block form-inline">
    @if($module->elaAuth('postRow'))
    <button id="crudadd" type="button" class="btn btn-primary" data-elaaction="postForm" data-elamodule="{{$module}}">
      <i class="fas fa-plus-circle"></i> {{ __('Add') }}
    </button>
    @endif
    </div>

    <div class="crud-paging mb-3 form-inline">
      <select class="form-control resultsperpage mr-2">
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
      </select>
      <button class="btn btn-secondary prev-page mr-2"><i class="fas fa-step-backward"></i></button>
      <div class="input-group mr-2">
        <input type="text" class="form-control page" value="1" style="width:3em!important;text-align:center">
        <div class="input-group-append">
          <span class="input-group-text maxpage">/ 1</span>
        </div>
      </div>
      <button class="btn btn-secondary next-page"><i class="fas fa-step-forward"></i></button>
    </div>

    <div class="table-responsive">
    <table id="crud-table" class="table table-striped table-bordered">
      <thead>
        @foreach($module->elaColumns() as $column=>$config)
          <?php if($config->nonlistable??false) continue; ?>
          <th class="noselect"  {{ $config->realcolumn? ' data-column='.$column.' ':'' }}>{{$config->label??$column}}</th>
        @endforeach
        <th></th>
      </thead>
      <tbody>
        <?php //$module->elaActionGetRows(); ?>
      </tbody>
      <tfoot>
        @foreach($module->elaColumns() as $column=>$config)
          <?php if($config->nonlistable??false) continue; ?>
          <th class="noselect" {{ $config->realcolumn? ' data-column='.$column.' ':'' }}>{{$config->label??$column}}</th>
        @endforeach
        <th></th>
      </tfoot>
    </table>
    </div>

    <div class="crud-paging mb-3 mt-3 form-inline">
      <select class="form-control resultsperpage mr-2">
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
      </select>
      <button class="btn btn-secondary prev-page mr-2"><i class="fas fa-step-backward"></i></button>
      <div class="input-group mr-2">
        <input type="text" class="form-control page" value="1" style="width:3em!important;text-align:center">
        <div class="input-group-append">
          <span class="input-group-text maxpage">/ 1</span>
        </div>
      </div>
      <button class="btn btn-secondary next-page"><i class="fas fa-step-forward"></i></button>
    </div>

@endsection

@push('scripts')
<script>

var crudFilters = {
  sort: '{{$module->getKeyName()}}',
  direction: 'desc',
  resultsperpage: 10,
  page: 1,
  totalresults: 0,
  maxpage : 1
};



function redrawCrudTable(){
  var maxpage = crudFilters.maxpage;
  elaRequest('getRows', '{{$module}}', crudFilters).done(function(data){
    var tbody = $('#crud-table tbody');
    crudFilters.totalresults = data.totalresults;
    crudFilters.maxpage = Math.ceil(crudFilters.totalresults/crudFilters.resultsperpage);
    tbody.html(data.html);
    if(crudFilters.maxpage != maxpage) redrawFilters();
  }).fail(function(res){
    toastr.error(res.responseText);
  });
}


$('#crud-table th[data-column]').css('cursor','pointer').css('white-space','nowrap');

function redrawFilters(){
  crudFilters.maxpage = Math.ceil(crudFilters.totalresults/crudFilters.resultsperpage);
  if(crudFilters.maxpage < 1) crudFilters.maxpage = 1;
  if(crudFilters.page > crudFilters.maxpage) crudFilters.page = crudFilters.maxpage;
  console.debug(crudFilters);
  $('#crud-table th[data-column] i.fas').remove();
  $('#crud-table th[data-column='+crudFilters.sort+']').prepend(crudFilters.direction == 'desc'?' <i class="fas fa-sort-up"></i> ':' <i class="fas fa-sort-down"></i> ');
  $('.crud-paging .resultsperpage').val(crudFilters.resultsperpage);
  $('.crud-paging .page').val(crudFilters.page);
  if(crudFilters.page == 1) $('.crud-paging .prev-page').attr('disabled', 'disabled');
  else $('.crud-paging .prev-page').removeAttr('disabled');
  if(crudFilters.page == crudFilters.maxpage) $('.crud-paging .next-page').attr('disabled', 'disabled');
  else $('.crud-paging .next-page').removeAttr('disabled');
  $('.crud-paging .maxpage').text('/ '+crudFilters.maxpage);
  redrawCrudTable();
}

redrawFilters();


$('#crud-table').on('click', 'th[data-column]',function(e){
  e.preventDefault();
  var el = $(this);
  var col = el.data('column');

  if(crudFilters.sort == col){
    if(crudFilters.direction == 'asc') crudFilters.direction = 'desc';
    else crudFilters.direction = 'asc';
  } else{
    crudFilters.sort = col;
    crudFilters.direction = 'asc';
  }
  redrawFilters();
});


$('.crud-paging .resultsperpage').change(function(){
  crudFilters.resultsperpage = this.value;
  redrawFilters();
});

$('.crud-paging .page').change(function(){
  var val = this.value;
  if(val !== '' + parseInt(val)) val=1;
  if(val < 1) val = 1;
  if(val > crudFilters.maxpage) val = crudFilters.maxpage;
  crudFilters.page = val;
  redrawFilters();
});

$('.crud-paging .prev-page').click(function(){
  var val = crudFilters.page;
  val --;
  if(val < 1) val = 1;
  crudFilters.page = val;
  redrawFilters();
});

$('.crud-paging .next-page').click(function(){
  var val = crudFilters.page;
  val ++;
  if(val > crudFilters.maxpage) val = crudFilters.maxpage;
  crudFilters.page = val;
  redrawFilters();
});



</script>
@endpush
