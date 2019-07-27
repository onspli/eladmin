@extends('layout')
@section('title', $elaModule->elaGetTitle())

@section('content')
@include($elaModule->bladeViewRender)
@endsection
