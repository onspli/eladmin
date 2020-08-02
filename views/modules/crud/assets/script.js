/**
* Holding crud filter config.
*/
var crudRequest = {
  sortBy : null,
  direction : null,
  resultsPerPage : 10,
  page : 1,
  search : '',
  filters : {},
  trash : 0,
  onlyIds : 0
};

/**
* Holding response values
*/
var crudResponse = {
  maxPage : 1,
  results : 0,
  totalResults : 0
};

/**
* We need to track read requests count to draw the last request onlz.
*/
var crudReadRequestCount = 0;

/**
* Default search icon
*/
var crudSearchIconDefault = $('.crud-paging .searchicon').html();

/**
* Populate table with data accoring to filters, paging and other setting.
*/
function crudRead() {
  crudReadRequestCount++;
  var crudCurrentReadRequestCount = crudReadRequestCount;

  crudRequest.onlyIds = 0;
  (function(crudCurrentReadRequestCount){
    elaRequest({module : elaElementModule($('#crud-table')[0]), action : 'read', post : crudRequest})
    .done(function(data){
      // it wasn't response to the last request, skip update
      if (crudCurrentReadRequestCount < crudReadRequestCount){
        console.debug('Request #' + crudCurrentReadRequestCount + ' skipped. Last request is #' + crudReadRequestCount + '.');
        return;
      }
      $('.crud-paging .searchicon').html(crudSearchIconDefault);

      // probably php error
      if (data.totalResults === undefined) {
        toastr.error(_msg_dbError);
        return;
      }

      crudResponse.results = data.ids.length;
      crudResponse.totalResults = data.totalResults;
      crudResponse.maxPage = Math.ceil(crudResponse.totalResults / crudRequest.resultsPerPage);

      // we deleted all items on last page. So the last page decremented and we need to redraw.
      if (crudRequest.page > crudResponse.maxPage && crudResponse.totalResults != 0) {
        redrawCrudControls();
        crudRead();
        return;
      }

      redrawCrudControls();

      var tbody = $('#crud-table tbody');
      tbody.empty();
      for (var i = 0; i < crudResponse.results; i++){
        var tr = rowFactory(data.ids[i], data.rows[i], data.actions[i]);
        tbody.append(tr);
      }

      if (crudResponse.totalResults == 0) {
        tbody.html('<tr><td colspan="1000" class="crud-loading"><i class="fas fa-dove"></i> ' + _msg_nothingFound + '</td></tr>');
      }
      $('.results-shown').text(crudResponse.results);
      $('.results-total').text(crudResponse.totalResults);
      bulkRedraw();
      consecutive.point('crud_read');

    })
    .fail(function(res){
      // it wasn't response to the last request, skip update
      if (crudCurrentReadRequestCount < crudReadRequestCount){
        console.debug('Request #' + crudCurrentReadRequestCount + ' skipped. Last request is #' + crudReadRequestCount + '.');
        return;
      }
      $('.crud-paging .searchicon').html(crudSearchIconDefault);
    });
  })();

}

/**
* Validate and update crudResponse and crudRequest values
*/
function validateCrudRequest() {

  // check if page number is a number
  var page = parseInt(crudRequest.page);
  if (isNaN(page))
    page = 1;
  crudRequest.page = page;

  if (crudRequest.page > crudResponse.maxPage)
    crudRequest.page = crudResponse.maxPage;

  if (crudRequest.page < 1)
    crudRequest.page = 1;
}

/**
* Redraw all controls to match crudRequest config
*/
function redrawCrudControls() {
  validateCrudRequest();

  $('#crud-table th[data-column] .arr.active').removeClass('active');
  $('#crud-table th[data-column=' + crudRequest.sortBy + '] .arr.' + (crudRequest.direction == 'desc' ? 'desc' : 'asc')).addClass('active');

  if (crudRequest.page <= 1) {
    $('.crud-paging .prev-page').attr('disabled', 'disabled');
  } else {
    $('.crud-paging .prev-page').removeAttr('disabled');
  }

  if (crudRequest.page >= crudResponse.maxPage) {
    $('.crud-paging .next-page').attr('disabled', 'disabled');
  } else {
    $('.crud-paging .next-page').removeAttr('disabled');
  }
  $('.crud-paging .maxpage').text('/ ' + crudResponse.maxPage);

  // update UI with values from crudRequest
  $('.crud-paging *[data-crudrequest]').each(function() {
    $(this).val(crudRequest[$(this).data('crudrequest')]);
  });

  $('#crud-filters *[data-crudfilter]').each(function() {
    var filter = crudRequest.filters[$(this).data('crudfilter')];
    if (filter)
      $(this).val(filter.val);
    else
      $(this).val('');
  });

  if (crudRequest.trash) {
    $('.crud-trash').addClass('btn-warning').removeClass('btn-secondary');
  } else {
    $('.crud-trash').addClass('btn-secondary').removeClass('btn-warning');
  }
  console.debug(crudRequest);
}

/**
* Populate CRUD table on document load.
*/
window.addEventListener("load", function() {
  redrawCrudControls();
  crudRead();
});

/**
* Limit max length of string.
* If longer than maxLength, slice it and append substitute to the string.
*/
function str_limit(str, maxLength, substitute = "..."){
  return str.slice(0, maxLength) + (str.length > maxLength ? substitute : "");
}

/**
* Create one row for the CRUD table from READ action response.
*/
function rowFactory(id, values, actions){
  var tr = $('<tr></tr>');
  var bulk_td = $('<td class="text-center"><input class="bulk" type="checkbox" data-id="' + id + '"></td>');
  tr.append(bulk_td);
  for (var i = 0; i < values.length; i++) {
    var value = '';
    if (values[i] !== null && values[i] !== undefined)
      value = values[i].toString();
    var column = crudColumns[i];
    var td = $('<td></td>');
    if (column.limit && value.length > column.limit){
      var preview = str_limit(value, column.limit);
      td.attr("data-toggle", "tooltip");
      td.attr("title", value);
      if (column.raw)
        td.html(preview);
      else
        td.text(preview);
    }
    else {
      if (column.raw)
        td.html(value);
      else
        td.text(value);
    }
    tr.append(td);

  }

  var action_td = $('<td class="text-right"></td>');

  if (actions.length) {
    var action_dropdown = $('<span class="dropdown actions-dropdown"><button class="btn btn-secondary m-1 dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></button></span>');
    var action_div = $('<div class="dropdown-menu"></div>');

    for (action of actions)
      action_div.append(actionLinkFactory(action, id));
    action_dropdown.append(action_div);
    action_td.append(action_dropdown);
  }

  if (crudRequest.trash) {
    action_td.append(actionButtonFactory('restore', id));
    action_td.append(actionButtonFactory('delete', id));
  } else {
    action_td.append(actionButtonFactory('updateform', id));
  }

  tr.append(action_td);
  return tr;
}

/**
* Create dropdown link for actioon
*/
function actionLinkFactory(name, id){
  if (crudActions[name] === undefined)
    return '';
  var action = crudActions[name];
  var button = $('<a href="#"></a>');
  button.attr('data-elaaction', name);
  button.attr('data-eladone', (action.done ? action.done : '') + ';bulkUncheckAll();crudRead();');
  button.attr('data-elagetid', id);
  if (action.form)
    button.attr('data-formaction', 'true');
  if (action.confirm !== undefined)
    button.attr('data-confirm', action.confirm ? action.confirm : action.action);
  button.attr('class', 'dropdown-item text-' + (action.style ? action.style : 'primary'));
  if (action.icon) {
    button.html(action.icon + ' <span class="d-none d-lg-inline">' + (action.label ? action.label : '') + '</span>');
  } else {
    button.html(action.label ? action.label : '');
  }
  return button;
}

/**
* Create button for actioon
*/
function actionButtonFactory(name, id){
  if (crudActions[name] === undefined)
    return '';
  var action = crudActions[name];
  var button = $("<button></button>");
  button.attr('data-elaaction', name);
  button.attr('data-eladone', (action.done ? action.done : '') + ';bulkUncheckAll();crudRead();');
  button.attr('data-elagetid', id);
  if (action.form)
    button.attr('data-formaction', 'true');
  if (action.confirm !== undefined)
    button.attr('data-confirm', action.confirm ? action.confirm : action.action);
  button.attr('class', 'btn m-1 btn-' + (action.style ? action.style : 'primary'));
  if (crudRequest.trash) {
    action.label = '';
  }
  if (action.icon) {
    button.html(action.icon + ' <span class="d-none d-lg-inline">' + (action.label ? action.label : '') + '</span>');
  } else {
    button.html(action.label ? action.label : '');
  }
  return button;
}

/**
* Sortable columns are clickable.
*/
$('#crud-table th[data-column]').css('cursor','pointer').css('white-space','nowrap');

/**
* Sort by column
*/
$('#crud-table').on('click', 'th[data-column]', function(e) {
  e.preventDefault();
  var el = $(this);
  var col = el.data('column');

  if (crudRequest.sortBy == col) {
    if (crudRequest.direction == 'asc')
      crudRequest.direction = 'desc';
    else
      crudRequest.direction = 'asc';
  } else {
    crudRequest.sortBy = col;
    crudRequest.direction = 'asc';
  }
  redrawCrudControls();
  crudRead();
});

/**
* Change crudrequest while typing.
*/
$('#crud-filters *[data-crudfilter]').on('input', function(){
  if($(this).val())
    crudRequest.filters[$(this).data('crudfilter')] = { 'op' : '=', 'val' : $(this).val() };
  else
    delete crudRequest.filters[$(this).data('crudfilter')];
  redrawCrudControls();
  bulkUncheckAll();
  crudRead();
});

/**
* Change crudrequest while typing.
*/
$('.crud-paging *[data-crudrequest]').on('input', function(){
  var config = $(this).data('crudrequest');
  var val = $(this).val();
  if (config == 'page' && val === '') {
    return;
  }
  if (crudRequest[config] == val) {
    return;
  }
  if (config != 'page' && config != 'resultsPerPage') {
    bulkUncheckAll();
  }
  crudRequest[config] = val;
  redrawCrudControls();
  crudRead();
});

/**
* Show previous page.
*/
$('.crud-paging .prev-page').click(function() {
  crudRequest.page--;
  redrawCrudControls();
  crudRead();
});

/**
* Show next page.
*/
$('.crud-paging .next-page').click(function() {
  crudRequest.page++;
  redrawCrudControls();
  crudRead();
});

/**
* Erase search field.
*/
$('.crud-paging .erase').click(function() {
  if (crudRequest.search == '') {
    return;
  }
  crudRequest.search = '';
  bulkUncheckAll();
  redrawCrudControls();
  crudRead();
});

/**
* Toggle trashed items
*/
$('.crud-trash').click(function() {
  crudRequest.trash = crudRequest.trash ? 0 : 1;
  bulkUncheckAll();
  redrawCrudControls();
  crudRead();
});

/**
* Redraw on modal close
*/
$('#dynamic').on('hidden.bs.modal', function() {
  bulkUncheckAll();
  redrawCrudControls();
  crudRead();
});

/**
* Reset filters on collapse.
*/
$('div#crud-filters').on('hidden.bs.collapse', function () {
  if (Object.keys(crudRequest.filters).length != 0) {
    crudRequest.filters = {};
    bulkUncheckAll();
    redrawCrudControls();
    crudRead();
  }
  $('button.crud-filters').addClass('btn-secondary').removeClass('btn-primary');
});

/**
* Update Filters button on collapse shown.
*/
$('div#crud-filters').on('shown.bs.collapse', function () {
  $('button.crud-filters').addClass('btn-primary').removeClass('btn-secondary');
});

/**
*
*/
$(document).on('click', '*[data-elaupdateaction]', function(e){
  e.preventDefault();
  var el = this;
  elaElementRequest(el, {action : $(this).data('elaupdateaction'), post : $('#modal-form').serialize(), get : {'update' : 1}})
  .done(function() {
    elaElementRequest(el, {action : 'updateForm', silent: false, noerror: true});
  });
});

/**
* Bulk actions
*/
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
  if (bulkConfig.all) selected = crudResponse.totalResults - bulkConfig.ids.length;
  else selected = bulkConfig.ids.length;
  return selected;
}

function redrawItemsSelected(){
  $('.items-selected').text(bulkSelectedItemsCount());
}

function bulkActionsRedraw(){
  var selected = bulkSelectedItemsCount();
  if (!crudRequest.trash)
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

/**
* Redraw bulk checkoboxes according to bulkConfig;
*/
function bulkRedraw(){
  if (bulkConfig.all){
    $('.bulk').prop('checked', true);
    $('.bulk-all').prop('checked', true);
    for (id of bulkConfig.ids){
      $('.bulk[data-id=' + id + ']').prop('checked', false);
    }
  } else{
    $('.bulk').prop('checked', false);
    $('.bulk-all').prop('checked', false);
    for (id of bulkConfig.ids){
      $('.bulk[data-id=' + id + ']').prop('checked', true);
    }
  }
  redrawItemsSelected();
  bulkActionsRedraw();
}

/**
* Click on checkall checkbox.
*/
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

/**
* Click on row checkbox.
*/
$(document).on('click', 'input.bulk', function(){
  var elaid = $(this).data('id');
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

/**
*
*/
function doBulkAction(el, ids, request){
  var selected = bulkSelectedItemsCount();
  var finished = 0;
  var success = 0;
  var failed = 0;

  for (id of ids) {
    elaElementRequest(el, $.extend(true, {}, {
      action : $(el).data('elabulkaction'),
      silent : true,
      get : {id : id}
    }, request))
    .fail(function() {
      failed++;
    })
    .done(function() {
      success++;
    })
    .always(function() {
      finished++;
      if (finished >= selected) {
        if (success > 0) {
          toastr.info(_msg_bulkDone.replace('%success', success).replace('%failed', failed));
          modalClose();
          crudRead();
          bulkUncheckAll();
        } else {
          toastr.error(_msg_bulkDone.replace('%success', success).replace('%failed', failed));
        }
      }
    });
  }
}

function idsForBulkAction(el, request) {
  var confirmMsg = $(el).data('bulkconfirm');
  if (!confirmMsg)
    confirmMsg = _msg_areYouSure;
  var confirm = window.confirm( confirmMsg + ' (' + _msg_bulkConfirm.replace('%count', bulkSelectedItemsCount()) + ')');
  if(!confirm){
    return;
  }

  if (bulkConfig.all) {
    crudRequest.onlyIds = 1;
    elaRequest({ action : 'read', module : elaElementModule(el), post : crudRequest})
    .done(function(data){
      console.debug(data);
      for(id of bulkConfig.ids){
        data = data.filter(function(item) {
          return item !== id;
        });
      }
      doBulkAction(el, data, request);
    });
  } else{
    doBulkAction(el, bulkConfig.ids, request);
  }
}

$(document).on('eladone', '[data-elaaction]', function(){
  console.debug(this);
  console.debug($(this).data('formaction'));
  console.debug($(this).data('elagetid'));
  console.debug(isModalOpen() );
  console.debug($('#dynamic .modal form').data('elagetid'));
  if ($(this).data('formaction') && $(this).data('elagetid') && isModalOpen() && !$('#dynamic .modal form').data('elagetid')) {
    $('#dynamic .modal form').attr('data-elagetid', $(this).data('elagetid'));
  }
});

/**
*
*/
$(document).on('click', ':not(form)*[data-elabulkaction]', function(e){
  e.preventDefault();

  if ($(this).data('formaction')) {
    elaElementRequest($(this), {
      action : $(this).data('elabulkaction'),
      silent : false
    })
    .done(function(){
      var action = $('#dynamic .modal form').data('elaaction');
      $('#dynamic .modal form').removeAttr('data-elaaction');
      $('#dynamic .modal form').attr('data-elabulkaction', action);
    });
    return;
  }

  idsForBulkAction(this);

});

/**
*
*/
$(document).on('submit', '*[data-elabulkaction]', function(e) {
  e.preventDefault();
  idsForBulkAction(this, {post : $(this).serialize()});
});
