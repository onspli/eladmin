@extends('layout')

@section('title', $title)

@section('content')
<div class="card">
  <div class="card-body">
    <p>Modul "{{ $module }}" se načítá.</p>
  </div>
</div>
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
