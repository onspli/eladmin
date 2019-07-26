<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{$admintitle}} | @yield('title')</title>

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha256-UzFD2WYH2U1dQpKDjjZK72VtPeWP50NoJjd26rnAdUI=" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
<style>

body {
  overflow-x: hidden;
  background-color: #f5f5f5;
  font-family: 'Montserrat', sans-serif;
  font-size: 14px;
}

#page{margin: -2em 0px 1em 0px}
#mainbar{background-color: #4fd4cb;padding: 1em 1em 3em 1em}
.card{border-top: 2px solid #ffc107;margin-bottom: 1em}
.list-group-flush .list-group-item {  border: 0 !important}

.btn-primary{background-color:#3ba79f;border-color:#3ba79f}
.btn-primary:focus, .btn-primary:focus:active, .btn-primary:active, .btn-primary:hover {background-color: #2c968f !important;border-color: #2c968f!important;}
.btn-primary.focus, .btn-primary:focus {box-shadow: 0 0 0 0.2rem rgba(58, 183, 175, 0.28)!important;}

.menumodul i{
  font-size: 1.3em;
  text-align: center;
  color: #666666;
  margin-right: 0.5em;
  width: 1.3em;
}

.menumodul{
  font-size: 1.1em;
  font-weight: bold;
  padding-left: 2em;
}

.menumodul.selected{
  background-color: #ffedb8
}

.card-header h2{font-size: 1.8em}

h1.sidebar-heading{
  text-align: center;
  text-transform: uppercase;
  font-weight: bold;
  padding: 1em 0.2em;
  font-size: 1.3em;
}

h1.sidebar-heading a{
  color: inherit;
  text-decoration: none;
}

#sidebar-wrapper {
  background-color: #fff;
  min-height: 100vh;
  margin-left: -15rem;
  -webkit-transition: margin .25s ease-out;
  -moz-transition: margin .25s ease-out;
  -o-transition: margin .25s ease-out;
  transition: margin .25s ease-out;
}

#sidebar-wrapper .sidebar-heading {

}

#sidebar-wrapper .list-group {
  width: 15rem;
}

#page-content-wrapper {
  min-width: 100vw;
}

#wrapper.toggled #sidebar-wrapper {
  margin-left: 0;
}

@media (min-width: 768px) {
  #sidebar-wrapper {
    margin-left: 0;
  }

  #page-content-wrapper {
    min-width: 0;
    width: 100%;
  }

  #wrapper.toggled #sidebar-wrapper {
    margin-left: -15rem;
  }
}


</style>

</head>
<body>


    <div class="d-flex" id="wrapper">

      <!-- Sidebar -->
      <div class=" border-right" id="sidebar-wrapper">
        <h1 class="sidebar-heading"><a href=".">{{$admintitle}}</a></h1>
        <div>


        </div>

          @section('sidebar')
            <div class="list-group list-group-flush">
              @foreach($modules as $key=>$module)
                <a href="?elamodule={{$key}}" class="list-group-item  menumodul list-group-item-action
                @if(isset($elamodule) && ''.$key==$elamodule)
                 selected
                @endif
                 ">
                  <i class="{{ $module->elaGetFasIcon() }}"></i> {{ $module->elaGetTitle() }}
                </a>
              @endforeach
            </div>
          @show

      </div>
      <!-- /#sidebar-wrapper -->

      <!-- Page Content -->
      <div id="page-content-wrapper">

        <div id="mainbar">
          <button class="btn btn-primary" id="menu-toggle"><i class="fas fa-bars"></i></button>

          @if($useauth)
            <span class="float-right">
              <span>Přihlášen <strong>{{$username}}</strong> </span>&nbsp;
              @if($accountfields)
              <button class="btn btn-primary" id="elaeditaccount"><i class="fas fa-key"></i> <span class="d-none d-sm-inline">Účet</span> </button>
              @endif
              &nbsp;
              <a href="?elalogout=true" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i> <span class="d-none d-sm-inline">Odhlásit</span> </a>
            </span>
          @endif
        </div>

        <div id="page">
          <div class="container-fluid">
            <div id="content">
            @section('content')
            <h1 class="mt-4">Simple Sidebar</h1>
            <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p>
            <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>. The top navbar is optional, and just for demonstration. Just create an element with the <code>#menu-toggle</code> ID which will toggle the menu when clicked.</p>
            @show
            </div>

          </div>
        </div>

      </div>
      <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->


<div id="dynamic">
</div>





<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>

<script>

var csrftoken = '{{$csrftoken}}';
function reloadCSRFToken(){

  $.ajax({
    method: 'POST',
    url: '?elaaction=csrftoken'
  }).done(function(data){
    csrftoken = data;
    console.debug('CSRFToken '+csrftoken);
  });
}

function elaQuery(options){
  var settings = $.extend( {}, {
    action: 'action',
    module: '{{$elamodule??''}}',
    data: []
  }, options );
  return $.ajax({
      method: 'POST',
      url: '?elamodule='+settings.module+'&elaaction='+settings.action+'&elatoken='+csrftoken,
      data: settings.data
  }).fail(function(){
    reloadCSRFToken();
  });

}

function elaAuth(action, actionAuthRoles){
  @if($authroles)
  var userRoles = <?php echo json_encode($authroles, JSON_UNESCAPED_UNICODE); ?>;
  @else
  var userRoles = [];
  @endif
  var authRoles = actionAuthRoles[action.toLowerCase()];
  if(!authRoles || !authRoles.length) return true;
  var granted = false;
  $.each(userRoles, function(){
    if(authRoles.indexOf(this.toString()) >= 0) granted = true;
  });
  return granted;
}


/**
* Create responsive table element.
*/
function elaTable(options){
  return $('<div class="table-responsive"><table id="'+options.id+'" class="table table-striped table-sm table-bordered table-hover"><thead></thead><tbody></tbody><tfoot></tfoot></table></div>');
}

function elaCard(content, header){
  var card = $('<div class="card"></div>');
  if(header)
    card.append($('<div class="card-header"></div>').append($(header)));
  return card.append($('<div class="card-body"></div>').append($(content)));
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
