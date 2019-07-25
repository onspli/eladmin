@extends('layout')

@section('title', $title)

@section('content')
    <p>Modul "{{ $module }}" se načítá.</p>
@endsection

@section('scripts')
<script>
<?php readfile($js); ?>
</script>
@endsection
