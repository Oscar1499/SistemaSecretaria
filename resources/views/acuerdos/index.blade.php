@extends('adminlte::page')

@section('title', 'Listado de Acuerdos')

@section('content_header')
    <h1>Listado de Acuerdos</h1>
    <a href="{{ route('acuerdos.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Crear Nuevo Acuerdo
    </a>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Acuerdos Registrados</h3>
        </div>
        <div class="card-body">
            <table id="acuerdosTable" class="table table-bordered table-hover w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Acta</th>
                        <th>ID Personal</th>
                        <th>Fecha de Acuerdo</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($acuerdos as $acuerdo)
                        <tr>
                            <td>{{ $acuerdo->id_Acuerdo }}</td>
                            <td>{{ $acuerdo->id_Actas }}</td>
                            <td>{{ $acuerdo->id_Personal }}</td>
                            <td>{{ $acuerdo->fecha_Acuerdos }}</td>
                            <td>{{ $acuerdo->descripcion_Acuerdos }}</td>
                            <td>
                                <a href="#" class="btn btn-warning btn-sm">Editar</a>
                                <a href="#" class="btn btn-danger btn-sm">Eliminar</a>
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
            $('#acuerdosTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
                },
                "autoWidth": true,
                "responsive": true
            });
        });
    </script>
@stop
