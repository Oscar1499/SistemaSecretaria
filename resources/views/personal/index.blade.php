@extends('adminlte::page')

@section('title', 'Gestión de Personal')

@section('content_header')
<h1>Gestión de Personal</h1>
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#personalModal">
    <i class="fas fa-plus"></i> Agregar Personal
</button>
@stop
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<body>

</body>
<style>
    .bi1 {
        color: black;
        /* Color personalizado */
    }
</style>

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
                        <th class="text-center">
                            <span class="d-inline-flex align-items-center">
                                <i class="bi1 bi-person-badge-fill me-1"></i> ID
                            </span>
                        </th>
                        <th class="text-center">
                            <span class="d-inline-flex align-items-center">
                                <i class="bi1 bi-person-fill me-1"></i> Nombre
                            </span>
                        </th>
                        <th class="text-center">
                            <span class="d-inline-flex align-items-center">
                                <i class="bi bi-person-lines-fill me-1"></i> Apellido
                            </span>
                        </th>
                        <th class="text-center">
                            <span class="d-inline-flex align-items-center">
                                <i class="bi1 bi-briefcase-fill me-1"></i> Cargo
                            </span>
                        </th>
                        <th class="text-center">
                            <span class="d-inline-flex align-items-center">
                                <i class="bi1 bi-house-door-fill me-1"></i> Propietario
                            </span>
                        </th>
                        <th class="text-center">
                            <span class="d-inline-flex align-items-center">
                                <i class="bi1 bi-save-fill me-1"></i> Acciones
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($personal as $persona)
                    <tr>
                        <td class="text-center">{{ $persona->id }}</td>
                        <td class="text-center">{{ $persona->nombre }}</td>
                        <td class="text-center">{{ $persona->apellido }}</td>
                        <td class="text-center">{{ $persona->cargo ?? 'Sin asignar' }}</td>
                        <td class="text-center">{{ $persona->propietario ? 'Sí' : 'No' }}</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm" onclick="openEditModal({{ $persona }})" title="Editar a este personal"
                                data-bs-toggle="tooltip"><i class="bi bi-pencil"></i> Editar</button>
                            <form action="{{ route('personal.destroy', $persona->id) }}" method="POST" id="deleteForm" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return Eliminar(event);" title="Eliminar a este personal"
                                    data-bs-toggle="tooltip"><i class="bi bi-trash"></i> Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Alerta de éxito de Eliminado-->
@if(session('delete'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Operación exitosa!',
        text: "El personal ha sido eliminado correctamente.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 3000,
        toast: true,
        position: 'top-end'
    });
</script>

@endif
@stop
<script>
    // Inicializar tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    function Eliminar(event) {

        event.preventDefault();

        // Mostrar SweetAlert
        Swal.fire({
            icon: 'question',
            title: '¿Confirmar eliminación del personal?',
            text: 'Esta acción no se puede deshacer. ¿Está seguro de que desea eliminar este registro de personal?',
            confirmButtonText: 'Sí, eliminar',
            showCancelButton: true,
            timer: 5000,
            cancelButtonText: 'No, cancelar',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            // Si el usuario confirma, envía el formulario
            if (result.isConfirmed) {
                document.getElementById('deleteForm').submit();
            }
        });
    }
</script>

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
    #personalTable tbody tr {
        line-height: 1;
        height: 30px;
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        $('#personalTable').DataTable({
            "responsive": true,
            "scrollX": true,
            "autoWidth": false,
        });
    });

    function openEditModal(persona) {
        $('#personalModal').modal('show');
        $('#personalForm').attr('action', `/personal/${persona.id}`);
        $('#personalForm').find('input[name="_method"]').val('PUT');
        $('#nombre').val(persona.nombre);
        $('#apellido').val(persona.apellido);
        $('#cargo').val(persona.cargo);
        $('#propietario').prop('checked', persona.propietario == 1);
    }

    @if(session('success'))
    swal("Éxito", "{{ session('success') }}", "success");
    @endif
</script>
@stop

{{-- Incluye el modal desde un archivo separado --}}
@include('personal.modals.modal', ['propietarios' => $propietarios])