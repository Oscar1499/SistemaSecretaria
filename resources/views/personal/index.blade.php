@extends('adminlte::page')

@section('title', 'Personal')

@section('content_header')
    <h1>Gestión de Personal</h1>
    <a href="{{ route('personal.create') }}" class="btn btn-primary mb-3">Agregar Nuevo Personal</a>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Personal</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Cargo</th>
                        <th>Propietario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($personal as $persona)
                        <tr>
                            <td>{{ $persona->id_Personal }}</td>
                            <td>{{ $persona->nombre }}</td>
                            <td>{{ $persona->apellido }}</td>
                            <td>{{ $persona->cargo ?? 'Sin asignar' }}</td>
                            <td>{{ $persona->propietario ? 'Sí' : 'No' }}</td>
                            <td>
                                <a href="{{ route('personal.show', $persona->id_Personal) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('personal.edit', $persona->id_Personal) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('personal.destroy', $persona->id_Personal) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{-- Paginación (si está habilitada) --}}
            {{ $personal->links() }}
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Index de Personal cargado'); </script>
@stop
