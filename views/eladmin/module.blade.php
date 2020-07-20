@push('scripts')
<script src="{!! $eladmin->request($module->elakey(), '_script') !!}&ver={{ time() }}"></script>
@endpush

@extends('eladmin.layout')
@section('title', $module->elaGetTitle())

@section('content')
@include('render')
@endsection
