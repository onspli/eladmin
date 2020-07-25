/**
* POST request eladmin action
* - Logout when response is HTTP 401
* - Toaster error on fail
* - Open or reload modal if reponse contains modal HTML (unless silent option passed)
* - Toaster success if reponse is text/plain or doesnt contain modal HTML (unless silent option passed)
*/
function elaRequest(request) {
  request = $.extend({}, {
    elamodule : null,
    elaaction : null,
    elatoken : _csrftoken,
    get : {},             // get arguments
    post : {},            // post argument
    silent : true         // do not toastr or modal on success
  }, request);

  if (request.module === null) {
    throw 'You have to specify module!';
  }
  if (request.action === null) {
    throw 'You have to specify action!';
  }

  var promise = $.ajax({
      method : 'POST',
      url : '?' + $.param($.extend({}, request.get, {elamodule : request.module, elaaction : request.action, elatoken : _csrftoken})),
      data : request.post
  })
  .fail(function(response) {
    consecutive.point('request_fail', response);
    toastr.error(response.responseText);
    if (response.status == 401) {
      setTimeout(function() {
        location.reload();
      }, 3000);
    }
  });

  if (!request.silent) {

  promise.done(function(data, status, xhr) {
    var contentType = xhr.getResponseHeader("content-type") || "";
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
  });

  }

  promise.done(function(data) {
    consecutive.point('request_ok', data);
  });
  return promise;
}

/**
* Create request according to data-ela* properties of element
* data-elaaction
* data-elamodule
* data-elapost* ... postargs
* data-elaget* ... getargs
* data-elasilent
* data-eladone
*/
function elaElementRequest(element, request) {
  var data = $(element).data();

  var htmlRequest = {
    action : $(element).data('elaaction'),
    module : $(element).data('elamodule'),
    silent : $(element).data('elasilent') ? true : false,
    post : {},
    get : {}
  };

  $.each(data, function(key,val) {
    if (key.startsWith('elapost')) {
      htmlRequest.post[key.substr(7)] = val;
      return;
    }
    if (key.startsWith('elaget')) {
      htmlRequest.get[key.substr(6)] = val;
      return;
    }
  });

  var promise = elaRequest($.extend({}, htmlRequest, request));
  (function(element) {
    promise.done(function(data, status, xhr) {
      $(element).trigger('eladone', [data, status, xhr]);
    });
  })();
  return promise;
}

/**
* Eladone event attribute
*/
$(document).on('eladone', '*[data-eladone]', function(e, data, status, xhr) {
  var exe = new Function($(this).data('eladone'));
  exe();
});

/**
* Eladmin action
*/
$(document).on('click', '*:not(form)[data-elaaction]', function(e) {
  e.preventDefault();
  elaElementRequest(this);
});

/**
* Eladmin action - modal forms
* Closes modal on success.
*/
$(document).on('submit', 'form[data-elaaction]', function(e) {
  e.preventDefault();
  elaElementRequest(this, {post : $(this).serialize()})
  .done(function(data) {
    modalClose();
  });
});

/**
* toggle menu side bar
*/
$(document).on('click', '#menu-toggle', function(e) {
  e.preventDefault();
  $('#wrapper').toggleClass('toggled');
});

/**
* tooltips on mouse hover
*/
$('body').tooltip({selector : '[data-toggle="tooltip"]', trigger : 'hover'});

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
  history.pushState({data : 'modal'}, '', '#modal');
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
$('#dynamic').on('hidden.bs.modal', function () {
  var type = window.location.hash.substr(1);
  if (type == 'modal') {
    history.back();
  }
});

/**
* confirm prompt, data-confirm="message"
*/
$(document).on('click', '*[data-confirm]', function(e){
  var confirm = window.confirm($(this).data('confirm'));
  if (!confirm) {
    e.preventDefault();
    e.stopImmediatePropagation();
  }
});
