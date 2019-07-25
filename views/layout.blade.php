<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Eladmin | @yield('title')</title>

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha256-UzFD2WYH2U1dQpKDjjZK72VtPeWP50NoJjd26rnAdUI=" crossorigin="anonymous" />
<style>

</style>

</head>
<body>

<div class="container-fluid">

@if($useauth)
@if($accountfields)
<a href="#" id="elaeditaccount"><i class="fas fa-user"></i> Účet</a>
@endif
<a href="?elalogout=true"><i class="fas fa-sign-out-alt"></i> Odhlásit</a>
@endif

<h2>Moduly:</h2>
@section('sidebar')
  <ul>
    @foreach($modules as $key=>$module)
      <li><a href="?elamodule={{$key}}">
        @if(isset($elamodule) && ''.$key==$elamodule)
          <strong>
        @endif
        <i class="{{ $module->elaGetFasIcon() }}"></i> {{ $module->elaGetTitle() }}
        @if(isset($elamodule) && ''.$key==$elamodule)
          </strong>
        @endif
      </a></li>
    @endforeach
  </ul>
@show

<h2>Obsah:</h2>
<div id="content">
@section('content')
      This is the content.
@show
</div>

<div id="dynamic">
</div>

</div>

<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>

function elaQuery(options){
  var settings = $.extend( {}, {
    action: 'action',
    module: '{{$elamodule??''}}',
    data: []
  }, options );

  return $.ajax({
    method: 'POST',
    url: '?elamodule='+settings.module+'&elaaction='+settings.action,
    data: settings.data
  });

}


/**
* Create responsive table element.
*/
function elaTable(options){
  return $('<div class="table-responsive"><table id="'+options.id+'" class="table table-striped table-sm table-bordered table-hover"><thead></thead><tbody></tbody><tfoot></tfoot></table></div>');
}

/**
* Create row element from data.
*/
function elaRow(data, options){
  var settings = $.extend( {}, {
    cell: 'td',
    useKeys:false
  }, options );

  var row = $('<tr></tr>');
  $.each(data, function(key,val){
    row.append($('<'+settings.cell+'></'+settings.cell+'>').text(settings.useKeys?key:val));
  });
  return row;
}

function elaInput(options){
  var opts = $.extend( {}, {
    label: '',
    name:'',
    value:'',
    placeholder: '',
    type:'text',
    disabled:false
  }, options );
  if(opts.type == 'hidden'){
    return $('<input type="hidden" name="'+opts.name+'" value="'+opts.value+'" >');
  }
  else if(opts.type == 'textarea'){
    return $('<div class="form-group"><label>'+opts.label+'</label><textarea '+(opts.disabled?' disabled="disabled" ':'')+' class="form-control" name="'+opts.name+'" placeholder="'+opts.placeholder+'">'+opts.value+'</textarea></div>');
  }
  return $('<div class="form-group"><label>'+opts.label+'</label><input '+(opts.disabled?' disabled="disabled" ':'')+' type="'+opts.type+'" class="form-control" name="'+opts.name+'" placeholder="'+opts.placeholder+'" '+(opts.value?' value="'+opts.value+'"':'')+'></div>');
}

function elaModal(options){
  var opts = $.extend( {}, {
    title:'Dialog',
    body:'',
    footer:''
  }, options );

  var elamodal = $('#elamodal');
  if(elamodal.length == 0){
    elamodal = $('<div id="elamodal" class="modal"><div class="modal-dialog"><div class="modal-content">\
                  <div class="modal-header">\
                          <h5 class="modal-title""></h5>\
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
                        </div>\
                        <div class="modal-body"></div>\
                        <div class="modal-footer"></div>\
                  </div></div></div>');
    $('#dynamic').append(elamodal);
  }
  elamodal.find('.modal-title').html(opts.title);
  elamodal.find('.modal-body').html(opts.body);
  elamodal.find('.modal-footer').html(opts.footer);
  elamodal.modal();
}

function elaModalHide(){
  $('#elamodal').modal('hide');
}

function elaForm(options){
  var form = $('<form id="'+options.id+'"></form>');
  form.on('submit', function(e){
    e.preventDefault();
    elaQuery($.extend( {}, options, {
      data: $(this).serialize()
    })).done(function(data){
      options.done(data);
    }).fail(function(data){
      console.error(data);
      toastr.error(data.responseText);
    });
  });
  return form;
}

function elaButton(options){
  var opts = $.extend( {}, {
    type: 'button',
    style: 'primary',
    label: 'Button'
  }, options );
  return $('<button type="'+opts.type+'" class="btn btn-'+opts.style+'">'+opts.label+'</button>');
}

@if($accountfields)

$('#elaeditaccount').click(function(e){
  e.preventDefault();
  var form = elaForm( {
    id: 'elaaccountedit',
    action: 'account',
    module: '',
    done: function(){
      elaModalHide();
      toastr.success('Uloženo!');
    }
  } );
  @foreach($accountfields as $name=>$field)
    form.append(elaInput({
      label: "{{ $field['label'] }}",
      type: "{{ $field['type'] }}",
      name: "{{ $name }}"
    }));
  @endforeach
  var footer = $(' <button type="button" class="btn btn-secondary" data-dismiss="modal">Zrušit</button> <button type="submit" class="btn btn-primary" form="elaaccountedit">Uložit změny</button>');
  elaModal({title: 'Tvůj účet', body: form, footer: footer});
})




@endif

</script>

@yield('scripts')

</body>
</html>
