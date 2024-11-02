@extends('adminlte::page')

@section('title', 'Detalles del Acta')

@section('content_header')
    <h1>Detalles del Acta</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>Libro: {{ $acta->id_libros }}</h5>
            <h5>Personal: {{ $acta->id_Personal }}</h5>
            <h5>Fecha: {{ $acta->fecha }}</h5>
            <h5>Descripción:</h5>
            <p>{{ $acta->descripcion }}</p>
        </div>
        <a href="{{ route('actas.index') }}" class="btn btn-secondary">Volver</a>
    </div>
@stop
