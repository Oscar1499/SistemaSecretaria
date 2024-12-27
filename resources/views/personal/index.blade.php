@extends('adminlte::page')

@section('title', 'Gestión de Personal')

@section('content_header')
<h1><i class="bi bi-people-fill me-2"></i>Gestión de Personal</h1>
<button class="btn btn-primary mb-3" onclick="openCreateModal()">
    <i class="fas fa-plus"></i> Añadir Nuevo Personal
</button>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<body>

</body>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title text-center">Personal registrado en el sistema</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="personalTable" class="table table-striped table-bordered text-center">
                <thead>
                    <tr>
                    <th>

                        <th><i class="bi1 bi-person-fill me-1"></i> Nombre</th>
                        <th><i class="bi bi-person-lines-fill me-1"></i> Apellido</th>
                        <th><i class="bi1 bi-briefcase-fill me-1"></i> Cargo</th>
                        <th><i class="bi1 bi-house-door-fill me-1"></i> Propietario</th>
                        <th><i class="bi1 bi-save-fill me-1"></i> Acciones</th>
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
                        <td style="width: 250px;" >
                            <button class="btn btn-info btn-sm " onclick="openShowModal({{ $persona }})">
                            <i class="bi bi-eye"></i> Ver
                            </button>
                            <button class="btn btn-warning btn-sm " onclick="openEditModal({{ $persona }})">
                                <i class="bi bi-pencil"></i> Editar
                            </button>
                            <form action="{{ route('personal.destroy', $persona->id) }}" method="POST" id="deleteForm-{{ $persona->id }}" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="Eliminar(event, 'deleteForm-{{ $persona->id }}')">
                                    <i class="bi bi-trash"></i>Eliminar
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

    //Funcion para la creación de un nuevo registro en el formulario de agregar
    function openCreateModal() {
        $('#personalModal').modal('show');
        $('#personalForm').attr('action', '/personal');
        $('#personalForm').find('input[name="_method"]').val('POST');
        $('#personalForm').trigger('reset');
        $('#propietario').prop('checked', false);
    }

    // Funcion para la edición de un registro en el formulario de editar
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

    // Funcion para la visualización de un registro
    function openShowModal(persona) {
        $('#personalModal').modal('show');
        $('#nombre').val(persona.nombre).prop('disabled', true);
        $('#apellido').val(persona.apellido).prop('disabled', true);
        $('#cargo').val(persona.cargo).prop('disabled', true);
        $('#genero').val(persona.genero).prop('disabled', true);
        $('#search-cargo').val(persona.cargo).prop('disabled', true);
        $('#guardar').prop('disabled', true);
        $('#rubricas').val(persona.rubricas).prop('disabled', true);
        $('#propietario').prop('checked', persona.propietario == 1).prop('disabled', true);
    }

    // Resetea el formulario al cerrar el modal, y reestablece la acción a la ruta de creación
    $('#personalModal').on('hidden.bs.modal', function() {
        $('#personalForm').trigger('reset');
        $('#personalForm').attr('action', '/personal');
        $('#personalForm').find('input[name="_method"]').val('POST');
        $('#nombre').prop('disabled', false);
        $('#apellido').prop('disabled', false);
        $('#cargo').prop('disabled', false);
        $('#genero').prop('disabled', false);
        $('#search-cargo').prop('disabled', false);
        $('#guardar').prop('disabled', false);
        $('#rubricas').prop('disabled', false);
        $('#propietario').prop('disabled', false);
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
</script>

<!-- Sección de mensajes de alertas success -->

@if(session('success_create'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Personal creado!',
        text: "El personal se ha creado correctamente. Puedes verlo en la lista de personal.",
        toast: true,
        position: 'top-end',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif
@if(session('success_update'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Personal actualizado!',
        text: "El personal se ha actualizado correctamente. Puedes ver los cambios en la lista de personal.",
        toast: true,
        position: 'top-end',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif
@if(session('success_delete'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Operación exitosa!',
        text: "El personal ha sido eliminado correctamente. Puedes ver los cambios en la lista de personal.",
        toast: true,
        position: 'top-end',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif

<!-- Seccion de alertas error  -->

@if(session('error_create'))
<script>
    Swal.fire({
        icon: 'error',
        title: '¡Error al crear!',
        text: "Hubo un problema al crear el personal. Verifica que hayas ingresado todos los campos obligatorios y que el personal no se encuentre duplicado. Inténtalo de nuevo.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 5000,
        toast: true,
        position: 'top-end'
    });
</script>
@endif
@if(session('error_update'))
<script>
    Swal.fire({
        icon: 'error',
        title: '¡Error al actualizar!',
        text: "Hubo un problema al actualizar el personal. Verifica que hayas ingresado todos los campos obligatorios y que el personal no se encuentre duplicado. Inténtalo de nuevo.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 5000,
        toast: true,
        position: 'top-end'
    });
</script>
@endif
@if(session('error_delete'))
<script>
    Swal.fire({
        icon: 'error',
        title: '¡Error al eliminar!',
        text: "No se pudo eliminar el personal. Por favor, verifica si está asociado a otras entidades o en uso en el sistema e inténtalo de nuevo.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 5000,
        toast: true,
        position: 'top-end'
    });
</script>
@endif
@stop
