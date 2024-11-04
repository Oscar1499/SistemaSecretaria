@extends('adminlte::page')

@section('title', 'Lista de Libros')

@section('content_header')
    <h1>Libros</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('libros.create') }}" class="btn btn-primary">Agregar Nuevo Libro</a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Año</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($libros as $libro)
                 
                        <tr>
                            <td>{{ $libro->id_Libros }}</td>
                            <td>{{ $libro->anio }}</td>
                            <td>{{ $libro->descripcion_Libro }}</td>
                            <td>
                                
                                <a href="{{ route('libros.show', $libro->id_Libros) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('libros.edit',$libro->id_Libros) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('libros.destroy', $libro->id_Libros) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
