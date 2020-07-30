<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Eladmin | {{$eladmin->title()}}</title>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link href="{!! $eladmin->assetUrl('toastr-2.1.3/toastr.min.css', '2.1.3') !!}" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

<style>
body{background-color: #f5f5f5;font-family: 'Montserrat', sans-serif;font-size: 14px;}
h4{text-transform: uppercase;}
.card{border-top: 2px solid #ffc107;margin-bottom: 1em}
.btn-primary{background-color:#3ba79f;border-color:#3ba79f}
.btn-primary:focus, .btn-primary:focus:active, .btn-primary:active, .btn-primary:hover {background-color: #2c968f !important;border-color: #2c968f!important;}
.btn-primary.focus, .btn-primary:focus {box-shadow: 0 0 0 0.2rem rgba(58, 183, 175, 0.28)!important;}
</style>

</head>
<body>

<div class="container mb-5 mt-5">
  <div class="row">
    <div class="col-xl-4 offset-xl-4 col-lg-6 offset-lg-3 col-md-8 offset-md-2">
    <div class="card">
    <article class="card-body">

      <h4 class="card-title text-center mb-4 mt-1">{{$eladmin->title()}}</h4>
    	<hr>

      <form method="post" action="?elalogin=true" id="loginform">
        @foreach($loginFields as $name=>$field)
        <div class="form-group">
          <label>{{$field['label']}}</label>
          <input type="{{$field['type']}}" class="form-control" name="{{$name}}">
        </div>
        @endforeach
        <button type="submit" class="btn btn-primary btn-block">{{ __('Log in') }}</button>
      </form>

      <hr>
      <small class="text-center d-block"><a href="https://github.com/onspli/eladmin">Eladmin</a> {{ $eladmin->version() }} | CRUD admin interface</small>

    </article>
    </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="{!! $eladmin->assetUrl('toastr-2.1.3/toastr.min.js', '2.1.3') !!}"></script>

<script>
$(function(){
  $('#loginform').submit(function(e){
    e.preventDefault();
    $.ajax({
      url: $(this).attr('action'),
      method: $(this).attr('method'),
      data: $(this).serialize()
    }).done(function(){
      consecutive.point('login_ok');
      location.reload();
    }).fail(function(data){
      consecutive.point('login_fail', data.responseText);
      toastr.error(data.responseText);
    });
  });
});
</script>
@include('modules.core.consecutive')

</body>
</html>
