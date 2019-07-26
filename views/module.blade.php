@extends('layout')
@section('title', $elaModule->elaGetTitle())

@section('content')
<?php $elaModule->elaRender(); ?>
@endsection
