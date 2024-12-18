@extends('adminlte::page')

@section('title', 'Gestión de Personal')

@section('content_header')
<h1>Gestión de Personal</h1>
<button class="btn btn-primary mb-3" onclick="openCreateModal()">
    <i class="fas fa-plus"></i> Agregar Personal
</button>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listado de Personal</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="personalTable" class="table table-striped table-bordered table-hover w-100 mx-auto">
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
                                <i class="bi bi-pencil"></i> Editar
                            </button>
                            <form action="{{ route('personal.destroy', $persona->id) }}" method="POST" id="deleteForm-{{ $persona->id }}" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="Eliminar(event, 'deleteForm-{{ $persona->id }}')">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('personal.modals.modal', ['propietarios' => $propietarios])
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
    #personalTable tbody tr {
        line-height: 1;
        height: 44px;
    }

    #personalTable td,
    #personalTable th {
        padding: 0.25rem;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#personalTable').DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "No hay datos disponibles en la tabla",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ registros",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron coincidencias",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": activar para ordenar la columna de manera ascendente",
                    "sortDescending": ": activar para ordenar la columna de manera descendente"
                }
            },
            "autoWidth": true,
            "responsive": true,
            initComplete: function() {
                // Agregar placeholder al campo de búsqueda
                $('.dataTables_filter input').attr('placeholder', 'Buscar registros...');
            }
        });
    });

    function openCreateModal() {
        $('#personalModal').modal('show');
        $('#personalForm').attr('action', '/personal');
        $('#personalForm').find('input[name="_method"]').val('POST');
        $('#personalForm').trigger('reset');
        $('#propietario').prop('checked', false);
    }

    function openEditModal(persona) {
        $('#personalModal').modal('show');
        $('#personalForm').attr('action', `/personal/${persona.id}`);
        $('#personalForm').find('input[name="_method"]').val('PUT');
        $('#nombre').val(persona.nombre);
        $('#apellido').val(persona.apellido);
        $('#cargo').val(persona.cargo);
        $('#search-cargo').val(persona.cargo);
        $('#rubricas').val(persona.rubricas);
        $('#propietario').prop('checked', persona.propietario == 1);
    }


    $('#personalModal').on('hidden.bs.modal', function() {
        $('#personalForm').trigger('reset');
        $('#personalForm').attr('action', '/personal');
        $('#personalForm').find('input[name="_method"]').val('POST');
    });

    function Eliminar(event, formId) {
        event.preventDefault();
        Swal.fire({
            icon: 'question',
            title: '¿Eliminar personal?',
            text: 'Esta acción no se puede deshacer. ¿Está seguro de eliminar este Personal?',
            confirmButtonText: 'Sí, eliminarlo',
            showCancelButton: true,
            cancelButtonText: 'No, cancelar',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: "{{ session('success') }}",
        toast: true,
        position: 'top-end',
        timer: 3000,
        showConfirmButton: false
    });
    @endif
</script>
@stop
