<div id="mainbar">
  <button class="btn btn-primary" id="menu-toggle"><i class="fas fa-bars"></i></button>

@if($eladmin->username() !== null)
  <span class="float-right">
    <span>{{ __('Logged in as') }} <strong>{{$eladmin->username()}}</strong></span>
    &nbsp;
@if($eladmin->accountFields())
    <button class="btn btn-primary" id="elaeditaccount" data-elaaction="accountForm" data-eladone="return;" data-elamodule="">
      <i class="fas fa-key"></i>
      <span class="d-none d-sm-inline"> {{__('Account')}}</span>
    </button>
@endif
    &nbsp;
    <a id="logout_button" href="?elalogout=true" class="btn btn-primary">
      <i class="fas fa-sign-out-alt"></i>
      <span class="d-none d-sm-inline">{{__('Log out')}}</span>
    </a>
  </span>
@else
  <span class="float-right"><strong>{{ __('Authorization is disabled!') }}</strong></span>
@endif
</div>

<div id="page">
<div class="container-fluid">
<div id="content" {!! isset($module) ? 'data-elamodule="' . $module->elakey() . '"' : '' !!}>

@section('content')
  <h1 class="mt-4">Simple Sidebar</h1>
  <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p>
  <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>. The top navbar is optional, and just for demonstration. Just create an element with the <code>#menu-toggle</code> ID which will toggle the menu when clicked.</p>
@show

</div>
<!-- /#content -->
</div>
</div>
<!-- /#page -->
