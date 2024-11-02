@extends('adminlte::page')

@section('title', 'Lista de Actas')

@section('content_header')
    <h1>Lista de Actas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('actas.create') }}" class="btn btn-primary">Añadir Nueva Acta</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Libro</th>
                        <th>Personal</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($actas as $acta)
                        <tr>
                            <td>{{ $acta->id_Actas }}</td>
                            <td>{{ $acta->libro->nombre ?? 'N/A' }}</td>
                            <td>{{ $acta->personal->nombre ?? 'N/A' }}</td>
                            <td>{{ $acta->fecha }}</td>
                            <td>{{ $acta->descripcion }}</td>
                            <td>
                                <a href="{{ route('actas.show', $acta->id_Actas) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('actas.edit', $acta->id_Actas) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('actas.destroy', $acta->id_Actas) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta acta?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
