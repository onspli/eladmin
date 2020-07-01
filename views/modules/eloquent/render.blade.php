@extends('layouts.card')

<?php
/**
* TODO: Hack:  poedit cannot extract gettext from javascript or HTML ??!!
*/
$loadingMessage = __('Loading data');
$nothingFoundMessage = __('Nothing found!');
$searchMessage = __('Search');
?>

@section('card-header')
<h2>{!! $module->elaGetIcon() !!} {{$module->elaGetTitle() }}</h2>
@endsection

@section('card-body')

@include('modules.eloquent.actions')
@if($module->elaAuth('read'))
@include('modules.eloquent.filters')
@include('modules.eloquent.paging')
@include('modules.eloquent.table')
@include('modules.eloquent.paging')
@endif

@endsection
