@extends('adminlte::page')

@section('title', 'Gestión de Personal')

@section('content_header')
    <h1>Gestión de Personal</h1>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#personalModal">
        <i class="fas fa-plus"></i> Agregar Personal
    </button>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Personal</h3>
        </div>
        <div class="card-body">
            <table id="personalTable" class="table table-bordered table-hover w-100">
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
                            <td>{{ $persona->id }}</td>
                            <td>{{ $persona->nombre }}</td>
                            <td>{{ $persona->apellido }}</td>
                            <td>{{ $persona->cargo ?? 'Sin asignar' }}</td>
                            <td>{{ $persona->propietario ? 'Sí' : 'No' }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="openEditModal({{ $persona }})">
                                    Editar
                                </button>
                                <form action="{{ route('personal.destroy', $persona->id) }}" method="POST" style="display:inline-block;">
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
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#personalTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json" // Traducción al español
                },
                "autoWidth": true // Asegura que las columnas se adapten automáticamente
            });
        });

        function openEditModal(persona) {
            $('#personalModal').modal('show');
            $('#personalForm').attr('action', `/personal/${persona.id_Personal}`);
            $('#personalForm').find('input[name="_method"]').val('PUT');
            $('#nombre').val(persona.nombre);
            $('#apellido').val(persona.apellido);
            $('#cargo').val(persona.cargo);
            $('#propietario').prop('checked', persona.propietario == 1);
        }
    </script>
@stop

{{-- Incluye el modal desde un archivo separado --}}
@include('personal.modals.modal', ['propietarios' => $propietarios])
