
var crudFilters = {
  sort: '{{$module->elaOrderBy??$module->getKeyName()}}',
  direction: '{{$module->elaOrderDirection??"desc"}}',
  resultsperpage: 10,
  page: 1,
  totalresults: 0,
  maxpage : 1,
  search:'',
  columns:{},
  trash: 0,
  onlyids: 0
};

var bulkConfig = {
  all: false,
  ids: []
};

function bulkCheckAll(){
  bulkConfig.all = true;
  bulkConfig.ids = [];
}

function bulkUncheckAll(){
  bulkConfig.all = false;
  bulkConfig.ids = [];
}

function bulkCheck(id){
  if (bulkConfig.all)
  {
    bulkConfig.ids = bulkConfig.ids.filter(function(item) {
      return item !== id;
    });
  }
  else
  {
    if (bulkConfig.ids.includes(id) == false){
      bulkConfig.ids.push(id);
    }
  }
}

function bulkUncheck(id){
  if (bulkConfig.all == false)
  {
    bulkConfig.ids = bulkConfig.ids.filter(function(item) {
      return item !== id;
    });
  }
  else
  {
    if (bulkConfig.ids.includes(id) == false){
      bulkConfig.ids.push(id);
    }
  }
}

function bulkSelectedItemsCount(){
  var selected = 0;
  if (bulkConfig.all) selected = crudFilters.totalresults - bulkConfig.ids.length;
  else selected = bulkConfig.ids.length;
  return selected;
}

function redrawItemsSelected(){
  $('.items-selected').text(bulkSelectedItemsCount());
}

function bulkActionsRedraw(){
  var selected = bulkSelectedItemsCount();
  if (!crudFilters.trash)
  {
    $('.bulk-action').show();
    $('.bulk-action-trash').hide();
  }
  else
  {
    $('.bulk-action').hide();
    $('.bulk-action-trash').show();
  }
  if (selected == 0){
    $('.bulk-action, .bulk-action-trash').prop('disabled', true);
  } else{
    $('.bulk-action, .bulk-action-trash').prop('disabled', false);
  }
}

function bulkRedraw(){
  if (bulkConfig.all){
    $('.bulk').prop('checked', true);
    $('.bulk-all').prop('checked', true);
    for (id of bulkConfig.ids){
      $('.bulk[data-elaid='+id+']').prop('checked', false);
    }
  } else{
    $('.bulk').prop('checked', false);
    $('.bulk-all').prop('checked', false);
    for (id of bulkConfig.ids){
      $('.bulk[data-elaid='+id+']').prop('checked', true);
    }
  }
  redrawItemsSelected();
  bulkActionsRedraw();
}

$(document).on('click', 'input.bulk-all', function(e){
  var el = $(this);
  var checked = el.prop('checked');
  if (checked) {
    bulkCheckAll();
  }
  else {
    bulkUncheckAll();
  }
  bulkRedraw();
  console.debug(bulkConfig);
});

$(document).on('click', 'input.bulk', function(){
  var elaid = $(this).data('elaid');
  var checked = $(this).prop('checked');
  if (checked) {
    bulkCheck(elaid);
  } else{
    bulkUncheck(elaid);
  }
  redrawItemsSelected();
  bulkActionsRedraw();
  console.debug(bulkConfig);
});

function str_limit(str, length, substitute="..."){
  return str.slice(0, length) + (str.length > length ? substitute : "");
}

function rowFactory(values, actions, columns){
  var tr = $('<tr></tr>');
  var bulk_td = $('<td class="text-center"><input class="bulk" type="checkbox" data-elaid="' + values[0] + '"></td>');
  tr.append(bulk_td);
  for(var i=1; i<values.length; i++){
    var value = values[i].toString();
    var column = columns[i];
    var td = $('<td></td>');
    if (column.limit && value.length > column.limit){
      var preview = str_limit(value, column.limit);
      td.attr("data-toggle", "tooltip");
      td.attr("title", value);
      if (column.raw) td.html(preview);
      else td.text(preview);
    }
    else {
      if (column.raw) td.html(value);
      else td.text(value);
    }
    tr.append(td);

  }
  var action_td = $('<td class="text-right"></td>');
  for(action of actions) action_td.append(actionButtonFactory(action));
  tr.append(action_td);
  return tr;
}

function actionButtonFactory(action){
  var button = $("<button></button>");
  button.attr('data-elaaction', action.action);
  button.attr('data-eladone', action.done?action.done:'' + ';redrawCrudTable();');
  button.attr('data-elamodule', action.module);
  button.attr('data-elaid', action.id);
  if(action.confirm !== undefined)
    button.attr('data-elaconfirm', action.confirm?action.confirm:action.action);
  button.attr('class', 'btn m-1 btn-'+(action.style?action.style:'primary'));
  if(action.icon){
    button.html( action.icon+' <span class="d-none d-lg-inline">'+ (action.label?action.label:'') + '</span>' );
  } else{
    button.html( (action.label?action.label:'') );
  }
  return button;
}

var readRequestCount = 0;
var searchiconHtml = $('.crud-paging .searchicon').html();
function redrawCrudTable(){

  @if(!$module->elaAuth('read'))
    return;
  @endif
  var maxpage = crudFilters.maxpage;
  $('.crud-paging .searchicon').html('<i class="fas fa-sync-alt fa-spin"></i>');

  // we want to update only last request
  readRequestCount++;
  var currentRequestCount = readRequestCount;
  crudFilters.onlyids = 0;
  (function(currentRequestCount){

    elaRequest('read', '{{$module->elakey()}}', crudFilters)
    .done(function(data){
      if (currentRequestCount < readRequestCount){
        console.debug('Request #'+currentRequestCount+ " skipped");
        return;
      }

      var tbody = $('#crud-table tbody');
      crudFilters.totalresults = data.totalresults;
      crudFilters.maxpage = Math.ceil(crudFilters.totalresults/crudFilters.resultsperpage);
      tbody.empty();
      for(var i=0; i<data.results; i++){
        var values = data.rows[i];
        var actions = data.actions[i];
        var tr = rowFactory(values, actions, data.columns);
        tbody.append(tr);
      }
      $('.crud-paging .searchicon').html(searchiconHtml);
      if(crudFilters.maxpage != maxpage) redrawFilters(crudFilters.totalresults==0);
      if(crudFilters.totalresults == 0){
        tbody.html('<tr><td colspan="1000" class="crud-loading"><i class="fas fa-dove"></i> {{ __('Nothing found!') }} </td></tr>');
      }
      $('.results-shown').text(data.results);
      $('.results-total').text(crudFilters.totalresults);
      bulkRedraw();
      consecutive.point('crud_read');
    })
    .fail(function(res){
      if (currentRequestCount < readRequestCount){
        console.debug('Request #'+currentRequestCount+ " skipped");
        return;
      }
      $('.crud-paging .searchicon').html(searchiconHtml);
      toastr.error(res.responseText);
    });

  })(currentRequestCount);
}


$(' #crud-table th[data-column]').css('cursor','pointer').css('white-space','nowrap');

function redrawFilters(doNotRedraw, doNotUncheckAll){
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

  if(!doNotUncheckAll)
    bulkUncheckAll();

  if(!doNotRedraw)
    redrawCrudTable();
}

window.addEventListener("load", function(){ redrawFilters(); });

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
  redrawFilters(false, true);
});

$(' .crud-paging *[data-crudfilter=search]').on('input', function(){
  crudFilters[$(this).data('crudfilter')] = $(this).val();
  redrawFilters(false);
});

$(' .crud-paging *[data-crudfilter]').change(function(){
  crudFilters[$(this).data('crudfilter')] = $(this).val();
  redrawFilters(false, $(this).data('donotuncheck'));
});

$(' #crud-filters *[data-crudfiltercolumn]').change(function(){
  if($(this).val())
    crudFilters.columns[$(this).data('crudfiltercolumn')] = { 'op':'=', 'val': $(this).val()};
  else
    delete crudFilters.columns[$(this).data('crudfiltercolumn')];
  redrawFilters(false);
});


$(' .crud-paging .prev-page').click(function(){
  crudFilters.page--;
  redrawFilters(false, true);
});

$(' .crud-paging .next-page').click(function(){
  crudFilters.page++;
  redrawFilters(false, true);
});

$(' .crud-paging .erase').click(function(){
  crudFilters.search= '';
  redrawFilters();
});

$(' .crud-trash').click(function(){
  crudFilters.trash= crudFilters.trash?0:1;
  redrawFilters();
});

$("#dynamic").on("hidden.bs.modal", function () {
  redrawCrudTable();
});

function doBulkAction(el, ids){
  var data = $(this).data();
  var args = {};
  $.each(data, function(key,val){
    if(!key.startsWith('elaarg')) return;
    args[key.substr(6)] = val;
  });

  var selected = bulkSelectedItemsCount();
  var finished = 0;
  var success = 0;
  var failed = 0;

  for(elaid of ids){

    elaRequest($(el).data('elabulkaction'), $(el).data('elamodule'), args, {elaid:elaid})
    .fail(function(response){
      finished++;
      failed++;
      if (response.status == 401) location.reload();
      toastr.error(response.responseText);
      if (finished >= selected){
        toastr.success('{!! __('Done. %s items was affected, %s failed.', "' + success +'", "' + failed +'") !!} ');
        var eladone = new Function('data', $(el).data('eladone')+';');
        eladone(data);
      }
    })
    .done(function(data, status, xhr){
      finished++;
      success++;
      if (finished >= selected){
        toastr.success('{!! __('Done. %s items was affected, %s failed.', "' + success +'", "' + failed +'") !!} ');
        var eladone = new Function('data', $(el).data('eladone')+';');
        eladone(data);
      }
    });

  }
}

$(document).on('click', '*[data-elabulkaction]', function(e){
  e.preventDefault();

  var confirm = window.confirm( $(this).data('bulkconfirm') + ' {!! __('This will affect %s items.', "' + bulkSelectedItemsCount() +'") !!} ');
  if(!confirm){
    return;
  }

  if (bulkConfig.all){
    crudFilters.onlyids = 1;
    var el = this;
    elaRequest('read', $(this).data('elamodule'), crudFilters)
    .done(function(data){
      console.debug(data);
      for(id of bulkConfig.ids){
        data = data.filter(function(item) {
          return item !== id;
        });
      }
      doBulkAction(el, data);
    })
    .fail(function(response){
      toastr.error(response.responseText);
    });
  } else{
    doBulkAction(this, bulkConfig.ids);
  }
});
