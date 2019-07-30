@extends('layouts.card')

<?php
/**
* TODO: Hack:  poedit cannot extract gettext from javascript or HTML ??!!
*/
$loadingMessage = __('Loading data');
$nothingFoundMessage = __('Nothing found!');
$searchMessage = __('Search');
?>

@section('card-header')
  <h2>{!! $module->elaGetIcon() !!} {{$module->elaGetTitle() }}</h2>
@endsection

@section('card-body')

  <style>
  #crud-table td {
    white-space: nowrap;
    vertical-align: middle;
  }

  .crud-paging.form-inline .form-control.form-sm-inline{
    display: inline-block !important;
    width: auto!important
  }
  .crud-paging.form-inline .input-group.form-sm-inline{
    width: auto!important;
    display:inline-flex;

  }

  #crud-table th[data-column]{
    padding-right: 1.8em;
    position: relative;
  }

  #crud-table th .arr{
    color: #ddd;
    font-family: sans-serif;
    width: 0.2em;
    display: inline-block;
  }

  #crud-table th .arr.active{
    color: #000;
  }

  #crud-table th .arrs{
    display: inline-block;
    position: absolute;
    right: 0.6em;
  }

  .crud-loading{
    font-size: 2em;
  }




  </style>

    <div class="actions mb-3 ">
    @if($module->elaAuth('postRow'))
    <button id="crudadd" type="button" class="btn btn-success"
      data-elaaction="postForm"
      data-elamodule="{{$module}}">
      <i class="fas fa-plus-circle"></i> {{ __('Add') }}
    </button>
    @endif
    @foreach($module->elaFilters() as $filter)
      <button href="#crud-filters"  class="btn btn-primary" data-toggle="collapse"><i class="fas fa-filter"></i> {{ __('Filters') }}</button>
      @break
    @endforeach
    @if($module->elaUsesSoftDeletes())
      <button class="btn btn-secondary crud-trash" data-toggle="collapse"><i class="fas fa-trash-restore"></i> {{ __('Trash') }}</button>
    @endif
    </div>

    @if($module->elaAuth('getRows'))

    <div id="crud-filters" class="form-inline collapse">
      @foreach($module->elaFilters() as $name=>$filter)
      <div class="input-group mr-2 mb-3">
        <div class="input-group-prepend">
          <label class="input-group-text">
            {!! $filter->icon !!}&nbsp;
            {{$filter->label??$name}} </label>
        </div>
        @if($filter->input == 'select')
          <select class="form-control" data-crudfiltercolumn="{{$filter->column??$name}}">
            <?php
            if(is_callable($filter->selectOptions)){
              $selectOptions = ($filter->selectOptions)($filter, $name, $module, $eladmin);
            } else{
              $selectOptions = $filter->selectOptions;
            }
            ?>
            @foreach($selectOptions as $value=>$label)
              <option value="{{$value}}">{{ $label }}</option>
            @endforeach
          </select>
        @else
          <input type="text" class="form-control" data-crudfiltercolumn="{{$filter->column??$name}}">
        @endif
      </div>
      @endforeach
    </div>

    @push('crud-paging')
    <div class="crud-paging form-inline">
      <div class="form-group mb-3 mr-2">
        <div class="input-group">
            <input type="text" class="form-control search" data-crudfilter="search" placeholder="{{$searchMessage}}">
            <div class="input-group-append">
              <button class="btn btn-primary searchicon" type="button" ><i class="fas fa-search"></i></button>
              <button class="btn btn-secondary erase" type="button" ><i class="fas fa-eraser"></i></button>
            </div>
        </div>
      </div>
      <div class="input-group mr-2 mb-3 form-sm-inline">
        <div class="input-group-prepend">
          <label class="input-group-text"><i class="fas fa-list"></i></label>
        </div>
        <select class="custom-select form-sm-inline resultsperpage" data-crudfilter="resultsperpage">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="50">50</option>
        </select>
      </div>
      <div class="input-group mb-3 form-sm-inline">
        <div class="input-group form-sm-inline">
          <div class="input-group-prepend">
            <button class="btn btn-warning prev-page"><i class="fas fa-step-backward"></i></button>
          </div>
          <input type="text" class="form-control form-sm-inline page" data-crudfilter="page" value="1" style="width:3em!important;text-align:center">
          <div class="input-group-append">
            <span class="input-group-text maxpage">/ 1</span>
            <button class="btn btn-warning next-page"><i class="fas fa-step-forward"></i></button>
          </div>
        </div>
      </div>
    </div>
    @endpush

    @stack('crud-paging')



    <div class="table-responsive mb-3">
    <table id="crud-table" class="table table-striped table-bordered">
      <thead>

        @foreach($module->elaColumns() as $column=>$config)
          <?php if($config->nonlistable??false) continue; ?>
          <th class="noselect"  {{ $config->realcolumn? ' data-column='.$column.' ':'' }}>
              {{$config->label??$column}}
              {!! $config->realcolumn? '<span class="arrs"><span class="arr desc">&#x2191;</span> <span class="arr asc">&#x2193;</span></span>' :''!!}
          </th>
        @endforeach
        <th></th>
      </thead>
      <tbody>
        <?php //$module->elaActionGetRows(); ?>
      </tbody>
      <tfoot>
        @foreach($module->elaColumns() as $column=>$config)
          <?php if($config->nonlistable??false) continue; ?>
          <th class="noselect"  {{ $config->realcolumn? ' data-column='.$column.' ':'' }}>
              {{$config->label??$column}}
              {!! $config->realcolumn? '<span class="arrs"><span class="arr desc">&#x2191;</span> <span class="arr asc">&#x2193;</span></span>' :''!!}
          </th>
        @endforeach
        <th></th>
      </tfoot>
    </table>
    </div>



    @stack('crud-paging')

    @endif

@endsection



@push('scripts')
<script>


var crudFilters = {
  sort: '{{$module->getKeyName()}}',
  direction: 'desc',
  resultsperpage: 10,
  page: 1,
  totalresults: 0,
  maxpage : 1,
  search:'',
  columns:{},
  trash: 0
};


  function redrawCrudTable(){

  @if(!$module->elaAuth('getRows'))
    return;
  @endif
  var maxpage = crudFilters.maxpage;
  //var loading = '<tr><td colspan="1000" class="crud-loading"><i class="fas fa-sync-alt fa-spin"></i> {{$loadingMessage}} </td></tr>';
  //$('#crud-table tbody').html($(loading));

  var searchiconHtml = $(' .crud-paging .searchicon').html();
  $(' .crud-paging .searchicon').html('<i class="fas fa-sync-alt fa-spin"></i>');

  //if(crudFilters.totalresults>0) $('#crud-table tbody').append($(loading));
  elaRequest('getRows', '{{$module}}', crudFilters).done(function(data){
    var tbody = $(' #crud-table tbody');
    crudFilters.totalresults = data.totalresults;
    crudFilters.maxpage = Math.ceil(crudFilters.totalresults/crudFilters.resultsperpage);
    tbody.html(data.html);
    $(' .crud-paging .searchicon').html(searchiconHtml);
    if(crudFilters.maxpage != maxpage) redrawFilters(crudFilters.totalresults==0);
    if(crudFilters.totalresults == 0){
      tbody.html('<tr><td colspan="1000" class="crud-loading"><i class="fas fa-dove"></i> {{ $nothingFoundMessage}} </td></tr>');
    }

  }).fail(function(res){
    toastr.error(res.responseText);
  });
}


$(' #crud-table th[data-column]').css('cursor','pointer').css('white-space','nowrap');

function redrawFilters(doNotRedraw){
  crudFilters.maxpage = Math.ceil(crudFilters.totalresults/crudFilters.resultsperpage);
  if(crudFilters.maxpage < 1) crudFilters.maxpage = 1;
  if(parseInt(crudFilters.page) != crudFilters.page) crudFilters.page = 1;
  if(crudFilters.page > crudFilters.maxpage) crudFilters.page = crudFilters.maxpage;
  if(crudFilters.page < 1) crudFilters.page = 1;

  console.debug(crudFilters);
  $(' #crud-table th[data-column] .arr.active').removeClass('active');
  $(' #crud-table th[data-column='+crudFilters.sort+'] .arr.'+(crudFilters.direction == 'desc'?'desc':'asc')).addClass('active');

  if(crudFilters.page == 1) $('.crud-paging .prev-page').attr('disabled', 'disabled');
  else $(' .crud-paging .prev-page').removeAttr('disabled');
  if(crudFilters.page == crudFilters.maxpage) $('.crud-paging .next-page').attr('disabled', 'disabled');
  else $(' .crud-paging .next-page').removeAttr('disabled');
  $(' .crud-paging .maxpage').text('/ '+crudFilters.maxpage);

  $(' .crud-paging *[data-crudfilter]').each(function(){
    $(this).val( crudFilters[$(this).data('crudfilter')] );
  });

  if(crudFilters.trash) $(' .crud-trash').addClass('btn-warning').removeClass('btn-secondary');
  else $(' .crud-trash').addClass('btn-secondary').removeClass('btn-warning');


  if(!doNotRedraw)
    redrawCrudTable();
}

redrawFilters();


$(' #crud-table').on('click', 'th[data-column]',function(e){
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

$(' .crud-paging *[data-crudfilter]').change(function(){
  crudFilters[$(this).data('crudfilter')] = $(this).val();
  redrawFilters();
})

$(' #crud-filters *[data-crudfiltercolumn]').change(function(){
  if($(this).val())
    crudFilters.columns[$(this).data('crudfiltercolumn')] = { 'op':'=', 'val': $(this).val()};
  else
    delete crudFilters.columns[$(this).data('crudfiltercolumn')];
  redrawFilters();
})


$(' .crud-paging .prev-page').click(function(){
  crudFilters.page--;
  redrawFilters();
});

$(' .crud-paging .next-page').click(function(){
  crudFilters.page++;
  redrawFilters();
});

$(' .crud-paging .erase').click(function(){
  crudFilters.search= '';
  redrawFilters();
});

$(' .crud-trash').click(function(){
  crudFilters.trash= crudFilters.trash?0:1;
  redrawFilters();
});



</script>
@endpush
