@extends('adminlte::page')

@section('title', 'Editar Acta')

@section('content_header')
    <h1>Editar Acta</h1>
@stop

@section('content')
    <form action="{{ route('actas.update', $acta->id_Actas) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="id_libros">Libro</label>
            <input type="number" class="form-control" id="id_libros" name="id_libros" value="{{ $acta->id_libros }}" required>
        </div>
        
        <div class="form-group">
            <label for="id_Personal">Personal</label>
            <input type="number" class="form-control" id="id_Personal" name="id_Personal" value="{{ $acta->id_Personal }}" required>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="{{ $acta->fecha }}" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion">{{ $acta->descripcion }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
@stop
