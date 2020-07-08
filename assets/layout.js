$(function(){


$(document).on('click', "#menu-toggle", function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});

$(document).on('click', '*[data-elaconfirm]', function(e){
  var confirm = window.confirm($(this).data('elaconfirm'));
  if(!confirm){
    e.preventDefault();
    e.stopImmediatePropagation();
  }
});

function isModalOpen()
{
  return $('#dynamic .modal').length != 0;
}

function modalClose()
{
  if (!isModalOpen()){
    throw 'Cannot close modal. Modal is closed already.';
  }
  $('#dynamic .modal').modal('hide');
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
  .fail(function(data){
      toastr.error(data.responseText);
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
  });
});

$(document).on('submit', 'form#modal-form', function(e){
  e.preventDefault();
  var form = $(this);
  elaRequest(form.data('elaaction'), form.data('elamodule'), form.serialize(), {elaid: form.data('elaid')})
  .fail(function(response){
    toastr.error(response.responseText);
  })
  .done(function(data){
    var eladone = new Function('data', form.data('eladone')+';  if(data) toastr.success(data);');
    eladone(data);
    modalClose();
  });
});

window.onpopstate = function(e){
  modalClose();
};

$('body').tooltip({selector: '[data-toggle="tooltip"]'});

/**
* on modal close
*/
$("#dynamic").on("hidden.bs.modal", function () {
  var type = window.location.hash.substr(1);
  if(type == 'modal') history.back();
});

});
