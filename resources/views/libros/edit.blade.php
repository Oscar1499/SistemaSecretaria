@extends('adminlte::page')

@section('title', 'Editar Libro')

@section('content_header')
<h1>Editar Libro</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('libros.update', $libro) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="anio">Año:</label>
                <input type="number" readonly name="anio" class="form-control" value="{{ $libro->anio }}" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" class="form-control" required>{{ $libro->descripcion_Libro }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('libros.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop