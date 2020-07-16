@push('scripts')
<script src="{!! $eladmin->request($module->elakey(), '_script') !!}&ver={{ time() }}"></script>
@endpush

@extends('layout')
@section('title', $module->elaGetTitle())

@section('content')
@include($module->elaGetView('render'))
@endsection
