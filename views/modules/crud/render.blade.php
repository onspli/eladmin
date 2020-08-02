@extends('layouts.card')

@section('card-header')
<h2>{!! $module->icon() !!} {{ $module->title() }}</h2>
@endsection

@section('card-body')

@include('actions')
@if($module->auth('read'))
@include('filters')
@include('paging')
@include('table')
@include('paging')
@endif

@endsection

@push('scripts')
<script>
var _msg_areYouSure = '{{ __("Are you sure?") }}';
var _msg_nothingFound = '{{ __("Nothing found!") }}';
var _msg_dbError = '{{ __("Cannot read from database!") }}';
var _msg_bulkConfirm = '{{ __("Action will affect %count items.") }}';
var _msg_bulkDone = '{{ __("Done. %success items was affected, %failed failed.") }}';
var crudColumns = {!! json_encode($module->getCrudColumns()->getConfig(), JSON_UNESCAPED_UNICODE) !!};
var crudActions = {};
@foreach($module->getCrudActions() as $action)
@if($module->auth($action->getName()))
crudActions['{{ $action->getName() }}'] = {!! json_encode($action->getAction(), JSON_UNESCAPED_UNICODE) !!};
@endif
@endforeach
</script>
@endpush
