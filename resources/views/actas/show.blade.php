@extends('adminlte::page')

@section('title', 'Detalles del Acta')

@section('content_header')
    <h1>Detalles del Acta</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h5><strong>Id Actas:</strong> {{ $acta->id_Actas }}</h5>
            <h5><strong>Libro:</strong> {{ $acta->id_libros }}</h5>
            <h5><strong>Fecha:</strong> {{ $acta->fecha }}</h5>
            <h5><strong>Correlativo:</strong> {{ $acta->correlativo }}</h5>
            <h5><strong>Contenido de Elaboración:</strong></h5>
            <p>{{ $acta->contenido_elaboracion }}</p>
            <h5><strong>Presentes:</strong> {{ $acta->presentes }}</h5>
            <h5><strong>Ausentes:</strong> {{ $acta->ausentes }}</h5>
            <h5><strong>Tipo de Sesión:</strong> {{ $acta->tipo_sesion }}</h5>
            <h5><strong>Contenido Acta:</strong> {{ $acta->motivo_ausencia }}</h5>
            
        </div>
        <a href="{{ route('actas.index') }}" class="btn btn-secondary">Volver</a>
    </div>
@stop
