@extends('adminlte::page')

@section('title', 'Agregar Libro')

@section('content_header')
    <h1>Agregar Libro</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('libros.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="anio">Año:</label>
                    <input type="number" name="anio" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="descripcion_Libro">Descripción:</label>
                    <textarea name="descripcion_Libro" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('libros.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop
