
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Bienvenido a mi panel</h1>
@stop

@section('content')
    <p>Contenido principal aquí.</p>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/custom.js') }}"></script>
@stop
