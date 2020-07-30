@push('scripts')
<script src="{!! $module->assetUrl('script.js') !!}"></script>
@endpush

@push('styles')
<link href="{!! $module->assetUrl('style.css') !!}" rel="stylesheet">
@endpush

@extends('modules.core.layout')
@section('title', $module->title())

@section('content')
@include('render')
@endsection
