/**
* POST request eladmin action
* - Logout when response is HTTP 401
* - Toaster error on fail
* - Open or reload modal if reponse contains modal HTML
* - Toaster success if reponse is text/plain or doesnt contain modal HTML
*/
function elaRequest(module, action, postargs, getargs) {
  if (module === null || module === undefined) {
    throw 'You have to specify module!';
  }
  if (action === null || module === undefined) {
    throw 'You have to specify action!';
  }
  return $.ajax({
      method : 'POST',
      url : '?' + $.param($.extend({}, {
                            elamodule : module,
                            elaaction : action,
                            elatoken : _csrftoken
                          }, getargs)),
      data : postargs
  })
  .fail(function(response) {
    consecutive.point('request_fail', response);
    toastr.error(response.responseText);
    if (response.status == 401) {
      setTimeout(function() {
        location.reload();
      }, 3000);
    }
  })
  .done(function(data, status, xhr) {
    var contentType = xhr.getResponseHeader("content-type") || "";
    console.debug('elaRequest response content type: ' + contentType);
    if (!data) {
      return;
    }
    if (contentType.indexOf('text/html') > -1) {
      try {
        var html = $(data);
        if(html.hasClass('modal')){
          modalOpen(html);
        } else {
          toastr.success(data);
        }
      } catch(e) {
        toastr.success(data);
      }
    } else if (contentType.indexOf('text/plain') > -1) {
        toastr.success(data);
    }
    consecutive.point('request_ok', data);
  });
}

/**
* toggle menu side bar
*/
$(document).on('click', "#menu-toggle", function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});

/**
* tooltips on mouse hover
*/
$('body').tooltip({selector: '[data-toggle="tooltip"]', trigger : 'hover'});

/**
* Check if modal window is open
*/
function isModalOpen() {
  return $('#dynamic>.modal').length != 0;
}

/**
* close modal window
*/
function modalClose() {
  if (!isModalOpen()) {
    return;
  }
  $('#dynamic>.modal').modal('hide');
  $('#dynamic').html('');
}

/**
* Open or reload modal
*/
function modalOpen(html) {
  if (isModalOpen()) {
    $('#dynamic').html(html);
    return;
  }
  $('#dynamic').html(html);
  html.modal();
  history.pushState({data:'modal'}, '', '#modal');
}

/**
* history.back event
*/
window.onpopstate = function(e){
  modalClose();
  consecutive.point('popstate');
};

/**
* on modal close event
*/
$("#dynamic").on("hidden.bs.modal", function () {
  var type = window.location.hash.substr(1);
  if (type == 'modal') {
    history.back();
  }
});

/**
* confirm prompt, data-elaconfirm="message"
*/
$(document).on('click', '*[data-elaconfirm]', function(e){
  var confirm = window.confirm($(this).data('elaconfirm'));
  if (!confirm) {
    e.preventDefault();
    e.stopImmediatePropagation();
  }
});

/**
* Create request according to data-ela* properties of element
* data-elaaction
* data-elamodule
* data-elaarg ... postargs
* data-ela* ... getargs
*/
function elaElementRequest(element, postargs) {
  var data = $(element).data();
  var action = data['elaaction'];
  var module = data['elamodule'];
  if (postargs === undefined)
    postargs = {};
  var getargs = {};
  $.each(data, function(key,val) {
    if (!key.startsWith('ela') || key.startsWith('elaaction') || key.startsWith('elamodule'))  {
      return;
    }
    if (key.startsWith('elaarg')) {
      postargs[key.substr(6)] = val;
      return;
    }
    getargs[key] = val;
  });
  return elaRequest(module, action, postargs, getargs);
}

/**
* Eladmin action
*
* data-elaaction
* data-elamodule
* data-elaarg ... postargs
* data-ela* ... getargs
*/
$(document).on('click', '*:not(form)[data-elaaction]', function(e){
  e.preventDefault();
  elaElementRequest(this)
});

/**
* Eladmin action - modal forms
* Closes modal on success.
*
* data-elaaction
* data-elamodule
* data-elaarg ... postargs
* data-ela* ... getargs
*/
$(document).on('submit', 'form[data-elaaction]', function(e){
  e.preventDefault();
  elaElementRequest(this, $(this).serialize())
  .done(function(data) {
    modalClose();
  });
});
