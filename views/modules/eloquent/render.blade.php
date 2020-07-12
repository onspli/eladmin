@push('styles')
<link href="{!! $eladmin->asset('modules/eloquent/style.css') !!}" rel="stylesheet">
@endpush

@extends('layouts.card')

@section('card-header')
<h2>{!! $module->elaGetIcon() !!} {{$module->elaGetTitle() }}</h2>
@endsection

@section('card-body')

@include($module->elaGetView('actions'))
@if($module->elaAuth('read'))
@include($module->elaGetView('filters'))
@include($module->elaGetView('paging'))
@include($module->elaGetView('table'))
@include($module->elaGetView('paging'))
@endif

@endsection
