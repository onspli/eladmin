<script>
  $(document).on('click', "#menu-toggle", function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });


  function elaRequest(action, module, args, getargs){
    if(module === null || module ===undefined){
      console.error('You have to specify module!');
      return;
      // module = '{{$eladmin->moduleKey()}}';
    }
    return $.ajax({
        method: 'POST',
        url: '?'+$.param($.extend({},{
          elamodule: module,
          elaaction: action,
          elatoken: '{{$eladmin->CSRFToken()}}'
        }, getargs)),
        data: args
    });
  }

  $(document).on('click', '*[data-confirm]', function(e){

    var confirm = window.confirm($(this).data('confirm'));
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
    elaRequest($(this).data('elaaction'), $(this).data('elamodule'), args).fail(function(data){
      toastr.error(data.responseText);
    }).done(function(data, status, xhr){
      var eladone = new Function('data', $(el).data('eladone')+'; if(data) toastr.success(data);');
      eladone(data);

      var ct = xhr.getResponseHeader("content-type") || "";
      //console.debug(ct);

      // HTML response
      if (ct.indexOf('html') > -1) {
      //  console.debug('html');
        try{
          var html = $(data);
          if(html.hasClass('modal')){
            $('#dynamic').html(html);
            html.modal();
          }
        } catch(v){

        }
      }
      // JSON response
      if (ct.indexOf('json') > -1) {
      //  console.debug('json');
      }

      // Text response
      if (ct.indexOf('plain') > -1) {

      }
    });
  });

  $(document).on('submit', 'form#modal-form', function(e){
    e.preventDefault();
    var form = $(this);
    elaRequest(form.data('elaaction'), form.data('elamodule'), form.serialize())
    .fail(function(response){
      toastr.error(response.responseText);
    }).done(function(data){
      var eladone = new Function('data', form.data('eladone')+';  if(data) toastr.success(data);');
      eladone(data);
      $('#dynamic .modal').modal('hide');

    });

  });
</script>
