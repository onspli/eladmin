<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{$eladmin->title()}} | @yield('title')</title>

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
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script>

  $(document).on('click', "#menu-toggle", function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });

  function elaRequest(action, module, args){
    if(module === null) module = '{{$eladmin->moduleKey()}}';
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

  $(document).on('submit', 'form#accountform', function(e){
    e.preventDefault();
    $.ajax({
      url: $(this).attr('action'),
      method: 'POST',
      data: $(this).serialize()
    }).fail(function(response){
      toastr.error(response.responseText);
    }).done(function(data){
      toastr.success('Uloženo!');
      $('#dynamic .modal').modal('hide');
    });

  });

  </script>

    <div class="d-flex" id="wrapper">

      <!-- Sidebar -->
      <div class=" border-right" id="sidebar-wrapper">
        <h1 class="sidebar-heading"><a href=".">{{$eladmin->title()}}</a></h1>
        <div>


        </div>

          @section('sidebar')
            <div class="list-group list-group-flush">
              @foreach($eladmin->modules() as $key=>$module)
                <a href="?elamodule={{$key}}" class="list-group-item  menumodul list-group-item-action
                @if(isset($elaModule) && ''.$eladmin->moduleKey() === ''.$key)
                 selected
                @endif
                 ">
                  {!! $module->elaGetIcon() !!} {{ $module->elaGetTitle() }}
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

          @if($eladmin->username() !== null)
            <span class="float-right">
              <span>Přihlášen <strong>{{$eladmin->username()}}</strong> </span>&nbsp;
              @if($eladmin->accountFields())
              <button class="btn btn-primary" id="elaeditaccount" data-elaaction="accountForm" data-elamodule=""><i class="fas fa-key"></i> <span class="d-none d-sm-inline">Účet</span> </button>
              @endif
              &nbsp;
              <a href="?elalogout=true" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i> <span class="d-none d-sm-inline">Odhlásit</span> </a>
            </span>
          @else
            <span class="float-right"><strong>Autorizace je vypnutá!</strong></span>
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

@yield('scripts')

</body>
</html>
