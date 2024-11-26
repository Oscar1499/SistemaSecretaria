@extends('adminlte::page')

@section('title', 'Detalles del Libro')

@section('content_header')
<h1>Detalles del Libro</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <h4>Año: {{ $libro->anio }}</h4>
        <p>Descripción: {{ $libro->descripcion_Libro }}</p>

        <h5>Actas Asociadas:</h5>
        @if($actas->isEmpty())
        <p>No hay actas asociadas.</p>
        @else
        <ul>
            @foreach ($actas as $acta)
            <li>{{ $acta->nombre }}</li>
            @endforeach
        </ul>
        @endif

        <a href="{{ route('libros.index') }}" class="btn btn-secondary">Volver a la lista</a>
    </div>
</div>
@stop