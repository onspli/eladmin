@extends('layout')
@section('title', $module->elaGetTitle())

@section('content')
@include($module->bladeViewRender)
@endsection
