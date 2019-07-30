@extends('layout')
@section('title', $module->elaGetTitle())

@section('content')
@include($module->elaGetView('render'))
@endsection
