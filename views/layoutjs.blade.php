<script>
  $(document).on('click', "#menu-toggle", function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });

  function elaRequest(action, module, args){
    if(module === null || module ===undefined){
      console.error('You have to specify module!');
      return;
      // module = '{{$eladmin->moduleKey()}}';
    }
    return $.ajax({
        method: 'POST',
        url: '?elamodule='+module+'&elaaction='+action+'&elatoken={{$eladmin->CSRFToken()}}',
        data: args
    });
  }

  $(document).on('click', '*[data-confirm]', function(e){
    e.preventDefault();
    var confirm = window.confirm($(this).data('confirm'));
    if(!confirm) e.stopImmediatePropagation();
  });

  $(document).on('click', '*[data-elaaction]', function(e){
    e.preventDefault();
    var el = this;
    var data = $(this).data();
    var args = {};
    $.each(data, function(key,val){
      if(!key.startsWith('elaarg')) return;
      args[key.substr(6)] = val;
    });
    elaRequest($(this).data('elaaction'), ($(this).data('elamodule')!==undefined)?$(this).data('elamodule'):null, args).fail(function(data){
      toastr.error(data.responseText);
    }).done(function(data, status, xhr){
      eval('with(data){'+$(el).data('eladone')+'}');
      if($(el).data('eladonotprocess')) return;

      var ct = xhr.getResponseHeader("content-type") || "";
      console.debug(ct);

      // HTML response
      if (ct.indexOf('html') > -1) {
        console.debug('html');
        var html = $(data);
        if(html.hasClass('modal')){
          $('#dynamic').html(html);
          html.modal();
        } else{
          toastr.success(data?data:'OK');
        }
      }
      // JSON response
      if (ct.indexOf('json') > -1) {
        console.debug('json');
      }

      // Text response
      if (ct.indexOf('plain') > -1) {
        console.debug('plain');
        toastr.success(data?data:'OK');
      }
    });
  });

  $(document).on('submit', 'form#modal-form', function(e){
    e.preventDefault();
    var form = $(this);
    $.ajax({
      url: $(this).attr('action'),
      method: 'POST',
      data: $(this).serialize()
    }).fail(function(response){
      toastr.error(response.responseText);
    }).done(function(data){
      toastr.success(data?data:'OK');
      $('#dynamic .modal').modal('hide');
      eval(form.data('eladone'));
    });

  });
</script>
