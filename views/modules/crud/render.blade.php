@extends('layouts.card')

@section('card-header')
<h2>{!! $module->elaIcon() !!} {{ $module->elaTitle() }}</h2>
@endsection

@section('card-body')

@include('actions')
@if($module->elaAuth('read'))
@include('filters')
@include('paging')
@include('table')
@include('paging')
@endif

@endsection

@push('scripts')
<script>
var _moduleElakey = '{{ $module->elakey() }}';
var _msg_nothingFound = '{{ __("Nothing found!") }}';
var _msg_dbError = '{{ __("Cannot read from database!") }}';
</script>
@endpush
