function elaRequest(action, module, args, getargs){
  if(module === null || module === undefined){
    throw 'You have to specify module!';
  }
  return $.ajax({
      method: 'POST',
      url: '?'+$.param($.extend({},{
        elamodule: module,
        elaaction: action,
        elatoken: _csrftoken
      }, getargs)),
      data: args
  });
}

$(function(){

// toggle menu side bar
$(document).on('click', "#menu-toggle", function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});

$('body').tooltip({selector: '[data-toggle="tooltip"]'});

function isModalOpen()
{
  return $('#dynamic>.modal').length != 0;
}

function modalClose()
{
  if (!isModalOpen()){
    return;
  }
  $('#dynamic>.modal').modal('hide');
  $('#dynamic').html('');
}

function modalOpen(html)
{
  if (isModalOpen()){
    throw 'Cannot open modal. Modal is open already.';
  }
  $('#dynamic').html(html);
  html.modal();
  history.pushState({data:'modal'}, '', '#modal');
}

// history.back event
window.onpopstate = function(e){
  modalClose();
  consecutive.point('popstate');
};

// on modal close event
$("#dynamic").on("hidden.bs.modal", function () {
  var type = window.location.hash.substr(1);
  if(type == 'modal') history.back();
});

$(document).on('click', '*[data-elaconfirm]', function(e){
  var confirm = window.confirm($(this).data('elaconfirm'));
  if(!confirm){
    e.preventDefault();
    e.stopImmediatePropagation();
  }
});


$(document).on('click', '*:not(form)[data-elaaction]', function(e){
  e.preventDefault();

  var el = this;
  var data = $(this).data();
  var args = {};
  $.each(data, function(key,val){
    if(!key.startsWith('elaarg')) return;
    args[key.substr(6)] = val;
  });

  elaRequest($(this).data('elaaction'), $(this).data('elamodule'), args, {elaid:$(this).data('elaid')})
  .fail(function(response){
    consecutive.point('action_fail', response);
    if (response.status == 401) location.reload();
    toastr.error(response.responseText);
  })
  .done(function(data, status, xhr){

    var eladone = new Function('data', $(el).data('eladone')+'; if(data) toastr.success(data);');
    eladone(data);

    var ct = xhr.getResponseHeader("content-type") || "";
    //console.debug(ct);

    // HTML response
    if (ct.indexOf('html') > -1) {
      //console.debug('html');
      try{
        var html = $(data);
        if(html.hasClass('modal')){
          modalOpen(html);
        }
      } catch(v){

      }
    }

    // JSON response
    if (ct.indexOf('json') > -1) {
      //console.debug('json');
    }

    // Text response
    if (ct.indexOf('plain') > -1) {

    }

    consecutive.point('action_ok', data);
  });
});

$(document).on('submit', 'form#modal-form', function(e){
  e.preventDefault();
  var form = $(this);
  elaRequest(form.data('elaaction'), form.data('elamodule'), form.serialize(), {elaid: form.data('elaid')})
  .fail(function(response){
    consecutive.point('form_fail', response);
    if (response.status == 401) location.reload();
    toastr.error(response.responseText);
  })
  .done(function(data){
    var eladone = new Function('data', form.data('eladone')+';  if(data) toastr.success(data);');
    eladone(data);
    modalClose();
    consecutive.point('form_ok', data);
  });
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
    elaRequest('putForm', form.data('elamodule'), {}, {elaid : form.data('elaid') }).done(function(html){
      $('#dynamic .modal-dialog').html($(html).find('.modal-dialog'));
    });
  });
});

});
