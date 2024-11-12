@extends('adminlte::page')

@section('title', 'Lista de Actas')

@section('content_header')
    <h1>Lista de Actas</h1>
    <a href="{{ route('actas.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Añadir Nueva Acta
    </a>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Actas Registradas</h3>
        </div>
        <div class="card-body">
            <table id="actasTable" class="table table-bordered table-hover w-100">
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

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#actasTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
                },
                "autoWidth": true,
                "responsive": true
            });
        });
    </script>
@stop
