@push('styles')
<link href="{!! $eladmin->request('_style', $module->elakey()) !!}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{!! $eladmin->request('_script', $module->elakey()) !!}&ver={{ time() }}"></script>
@endpush

@extends('layout')
@section('title', $module->elaGetTitle())

@section('content')
@include($module->elaGetView('render'))
@endsection
