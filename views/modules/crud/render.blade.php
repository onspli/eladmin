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
