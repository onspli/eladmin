<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>{{$eladmin->title()}} | @yield('title')</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha256-UzFD2WYH2U1dQpKDjjZK72VtPeWP50NoJjd26rnAdUI=" crossorigin="anonymous" />
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link href="{!! $eladmin->asset('toastr-2.1.3/toastr.min.css', '2.1.3') !!}" rel="stylesheet">
<link href="{!! $eladmin->asset('layout.css') !!}" rel="stylesheet">
@stack('styles')

<script src="{!! $eladmin->asset('consecutive.js') !!}"></script>

</head>
<body>

<div class="d-flex" id="wrapper">

<div class="border-right" id="sidebar-wrapper">
@include('sidebar')
</div>
<!-- /#sidebar-wrapper -->

<div id="page-content-wrapper">
@include('content')
</div>
<!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<div id="dynamic">
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="{!! $eladmin->asset('toastr-2.1.3/toastr.min.js', '2.1.3') !!}"></script>
<script src="{!! $eladmin->request('script', '') !!}"></script>
@stack('scripts')

<script src="{!! $eladmin->asset('e2e.js') !!}"></script>

</body>
</html>
