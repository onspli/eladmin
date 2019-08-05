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
  @include('layoutstyle')

</head>
<body>


    <div class="d-flex" id="wrapper">

      <!-- Sidebar -->
      <div class="border-right" id="sidebar-wrapper">
        <h1 class="sidebar-heading"><a href=".">{{$eladmin->title()}}</a></h1>
        <div class="list-group list-group-flush">
            @foreach($eladmin->modules() as $key=>$module)
              <a href="?elamodule={{$key}}" class="list-group-item  menumodul list-group-item-action
                  @if(isset($module) && (string)$eladmin->moduleKey() === (string)$module->elakey())
                   selected
                  @endif
                  ">
                  {!! $module->elaGetIcon() !!} {{ $module->elaGetTitle() }}
                </a>
            @endforeach
        </div>
      </div>
      <!-- /#sidebar-wrapper -->

      <!-- Page Content -->
      <div id="page-content-wrapper">

        <div id="mainbar">
          <button class="btn btn-primary" id="menu-toggle"><i class="fas fa-bars"></i></button>

          @if($eladmin->username() !== null)
            <span class="float-right">
              <span>{{ __('Logged in as') }} <strong>{{$eladmin->username()}}</strong> </span>&nbsp;
              @if($eladmin->accountFields())
              <button class="btn btn-primary" id="elaeditaccount" data-elaaction="accountForm" data-eladone="return;" data-elamodule=""><i class="fas fa-key"></i> <span class="d-none d-sm-inline"> {{__('Account')}}</span> </button>
              @endif
              &nbsp;
              <a href="?elalogout=true" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i> <span class="d-none d-sm-inline"> {{__('Log out')}}</span> </a>
            </span>
          @else
            <span class="float-right"><strong>{{ __('Authorization is disabled!!!') }}</strong></span>
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

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@include('layoutjs', ['eladmin'=>$eladmin, 'module'=>$module])
@stack('scripts')

</body>
</html>
