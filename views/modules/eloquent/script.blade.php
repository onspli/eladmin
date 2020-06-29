<?php
/**
* TODO: Hack:  poedit cannot extract gettext from javascript or HTML ??!!
*/
$loadingMessage = __('Loading data');
$nothingFoundMessage = __('Nothing found!');
$searchMessage = __('Search');
?>

var crudFilters = {
  sort: '{{$module->elaOrderBy??$module->getKeyName()}}',
  direction: '{{$module->elaOrderDirection??"desc"}}',
  resultsperpage: 10,
  page: 1,
  totalresults: 0,
  maxpage : 1,
  search:'',
  columns:{},
  trash: 0
};

function redrawCrudTable(){

  @if(!$module->elaAuth('read'))
    return;
  @endif
  var maxpage = crudFilters.maxpage;
  //var loading = '<tr><td colspan="1000" class="crud-loading"><i class="fas fa-sync-alt fa-spin"></i> {{$loadingMessage}} </td></tr>';
  //$('#crud-table tbody').html($(loading));

  var searchiconHtml = $(' .crud-paging .searchicon').html();
  $(' .crud-paging .searchicon').html('<i class="fas fa-sync-alt fa-spin"></i>');

  //if(crudFilters.totalresults>0) $('#crud-table tbody').append($(loading));
  elaRequest('read', '{{$module->elakey()}}', crudFilters).done(function(data){
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
    $(' .crud-paging .searchicon').html(searchiconHtml);
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

$(document).on('click', 'form *[data-elaupdateaction]', function(e){
  e.preventDefault();
  var form = $(this).closest('form');
  var el = $(this);

  elaRequest($(this).data('elaupdateaction'), form.data('elamodule'), form.serialize(), {elaid: $(this).data('elaid'), elaupdate: 1})
  .fail(function(response){
    toastr.error(response.responseText);
  }).done(function(response){
    var eladone = new Function('data', el.data('eladone')+';  if(data) toastr.success(data);');
    eladone(response);
  }).always(function(){
    elaRequest('putForm', '{{$module->elakey()}}', {}, {elaid : form.data('elaid') }).done(function(html){
      $('#dynamic .modal-dialog').html($(html).find('.modal-dialog'));
    });
  });


});

$("#dynamic").on("hidden.bs.modal", function () {
  redrawCrudTable();
});