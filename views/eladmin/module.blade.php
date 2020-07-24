@push('scripts')
<script src="{!! $module->elaAsset('script.js') !!}"></script>
@endpush

@push('styles')
<link href="{!! $module->elaAsset('style.css') !!}" rel="stylesheet">
@endpush

@extends('eladmin.layout')
@section('title', $module->elaTitle())

@section('content')
@include('render')
@endsection
