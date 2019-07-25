@extends('layout')

@section('title', $title)

@section('content')
    <p>Modul "{{ $module }}" se načítá.</p>
@endsection

@section('scripts')
<script>
<?php
foreach($js as $script){
  readfile($script);
  echo "\n";
} ?>
</script>
@endsection
