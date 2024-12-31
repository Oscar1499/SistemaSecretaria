@extends('adminlte::page')

@section('title', 'Lista de Actas')

@section('content_header')
<h1><i class="bi bi-file-earmark-text-fill me-2"></i>Lista de Actas</h1>
<a href="{{ route('actas.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Añadir Nueva Acta
</a>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<body>

</body>

@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title text-center">Actas registradas</h3>
    </div>
    <div class="card-body">
        <table id="actasTable" class="table table-striped table-bordered table-hover text-center w-100">
            <thead>
                <tr>
                    <th><i class="bi1 bi-person-badge-fill"></i> ID</th>
                    <th><i class="bi1 bi-book-fill"></i> Libro</th>
                    <th><i class="bi1 bi-people-fill"></i> Personal</th>
                    <th><i class="bi1 bi-calendar-fill"></i> Fecha</th>
                    <th><i class="bi1 bi-file-earmark-text-fill"></i> Descripción</th>
                    <th><i class="bi1 bi-save-fill"></i> Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($actas as $acta)
                <tr>
                    <td>{{ $acta->id_Actas }}</td>
                    <td>{{ $acta->libro->nombre ?? 'N/A' }}</td>
                    <td>{{ $acta->personal->nombre ?? 'N/A' }}</td>
                    <td>{{ $acta->fecha }}</td>
                    <td>{{ $acta->descripcion }}</td>
                    <td>
                        <a href="{{ route('actas.show', $acta->id_Actas) }}" class="btn btn-info btn-sm" title="Ver esta acta"

                            data-bs-toggle="tooltip"><i class="bi bi-eye"></i> Ver</a>
                        <a href="{{ route('actas.edit', $acta->id_Actas) }}" class="btn btn-warning btn-sm" title="Editar esta acta"

                            data-bs-toggle="tooltip"><i class="bi bi-pencil"></i> Editar</a>
                        <form action="{{ route('actas.destroy', $acta->id_Actas) }}" method="POST" style="display:inline;" id="deleteForm-{{ $acta->id_Actas }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return Eliminar(event, 'deleteForm-{{ $acta->id_Actas }}');" title="Eliminar esta acta"

                                data-bs-toggle="tooltip"><i class="bi bi-trash"></i> Eliminar</button>
                        </form>
                        @if ("Abierto" == "Abierto")
                        <a class="btn btn-secondary btn-sm" title="Cerrar esta acta"
                            data-bs-toggle="tooltip">
                            <i class="bi bi-lock"></i> Cerrar Acta
                        </a>
                        @else if ("Abierto" == "Cerrado")
                        <button type="button" class="btn btn-secondary btn-sm" title="No disponible o cerrado" disabled>
                            <i class="bi bi-unlock"></i> Acta cerrada
                        </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Alerta de éxito de Creación, Actualización y Eliminación-->
@if(session('success_delete'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Operación exitosa!',
        text: "El acta ha sido eliminada correctamente.",
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
        text: "El acta ha sido actualizada correctamente.",
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
        title: '¡Éxito!',
        text: "El acta se ha creado correctamente.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 3000,
        toast: true,
        position: 'top-end'
    });
</script>
@endif

<!-- Alerta de error de Creación, Actualización y Eliminación-->
@if(session('error_create'))
<script>
    Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: "Hubo un problema al guardar el acta. Inténtalo de nuevo.",
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
        text: "Hubo un problema al actualizar el acta. Inténtalo de nuevo.",
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
        text: "Hubo un problema al borrar el acta. Inténtalo de nuevo.",
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
            title: '¿Confirmar eliminación del acta?',
            text: 'Esta acción no se puede deshacer. ¿Está seguro de que desea eliminar esta acta?',
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
        $('#actasTable').DataTable({
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
