@extends('adminlte::page')

@section('title', 'Lista de Libros')

@section('content_header')
<h1>Lista de Libros</h1>
<a href="{{ route('libros.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Añadir Nuevo Libro
</a>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<body>

</body>
<style>
    .bi1 {
        color: black;
    }
</style>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title text-center">Libros Registrados</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="librosTable" class="table table-striped table-bordered text-center">
                <thead>
                    <tr>
                        <th><i class="bi1 bi-person-badge-fill"></i> N° Libro</th>
                        <th><i class="bi1 bi-calendar-fill"></i> Fecha Inicio</th>
                        <th><i class="bi1 bi-calendar-event-fill"></i> Fecha Final</th>
                        <th><i class="bi1 bi-file-earmark-text-fill"></i> Descripción</th>
                        <th><i class="bi1 bi-save-fill"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($libros as $libro)
                    <tr>
                        <td>{{ $libro->id_Libros }}</td>
                        <td>{{ $libro->fechainicio_Libro }}</td>
                        <td>{{ $libro->fechafinal_Libro }}</td>
                        <td>
                            <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ $libro->descripcion_Libro }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                <a href="{{ route('libros.show', $libro->id_Libros) }}" class="btn btn-info btn-sm" title="Ver este libro" data-bs-toggle="tooltip">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <a href="{{ route('libros.edit', $libro->id_Libros) }}" class="btn btn-warning btn-sm" title="Editar este libro" data-bs-toggle="tooltip">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form action="{{ route('libros.destroy', $libro->id_Libros) }}" method="POST" class="d-inline-block" id="deleteForm-{{ $libro->id_Libros }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return Eliminar(event, 'deleteForm-{{ $libro->id_Libros }}');" title="Eliminar este libro" data-bs-toggle="tooltip">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                                @if (date('n') == 12)
                                <a href="{{ route('libros.edit', $libro->id_Libros) }}" class="btn btn-secondary btn-sm" title="Cerrar este libro"
                                    data-bs-toggle="tooltip">
                                    <i class="bi bi-lock"></i> Cerrar libro
                                </a>
                                @else
                                <button type="button" class="btn btn-secondary btn-sm" title="No disponible" disabled>
                                    <i class="bi bi-unlock"></i> No disponible
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Alerta de éxito de Eliminado-->
@if(session('success_delete'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Operación exitosa!',
        text: "El libro se ha eliminado correctamente. No podrá ser recuperado.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 3000,
        toast: true,
        position: 'top-end'
    });
</script>
@endif
@if(session('success_update'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Operación exitosa!',
        text: "El libro se ha actualizado correctamente. Puedes ver los cambios en la lista de libros.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 3000,
        toast: true,
        position: 'top-end'
    });
</script>
@endif
@if(session('success_create'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Operación exitosa!',
        text: "El libro se ha creado correctamente. Puedes verlo en la lista de libros.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 3000,
        toast: true,
        position: 'top-end'
    });
</script>
@endif
@if(session('error_create'))
<script>
    Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: "Hubo un problema al crear el libro. Verifica que hayas ingresado todos los campos obligatorios y que el libro no se encuentre duplicado. Inténtalo de nuevo.",
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
        title: '¡Error!',
        text: "Hubo un problema al actualizar el libro. Verifica que hayas ingresado todos los campos obligatorios y que el libro no se encuentre duplicado. Inténtalo de nuevo.",
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
        title: '¡Error!',
        text: "Hubo un problema al eliminar el libro. Verifica que no tenga actas asociadas y que no esté en uso en el sistema. Inténtalo de nuevo.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 5000,
        toast: true,
        position: 'top-end'
    });
</script>
@endif
<script>
    // Inicializar tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    //Funcion especifica para eliminar un registro donde de espera 2 parametros
    function Eliminar(event, formId) {
        event.preventDefault();

        // Mostrar SweetAlert
        Swal.fire({
            icon: 'question',
            title: '¿Confirmar eliminación del libro?',
            text: 'Esta acción no se puede deshacer. ¿Está seguro de que desea eliminar este libro?',
            confirmButtonText: 'Sí, eliminar',
            showCancelButton: true,
            timer: 5000,
            cancelButtonText: 'No, cancelar',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            // Si el usuario confirma, envía el formulario
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>
@stop
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@stop

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#librosTable').DataTable({
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
</script>
@stop
