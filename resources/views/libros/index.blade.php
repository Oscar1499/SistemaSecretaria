@extends('adminlte::page')

@section('title', 'Lista de Libros')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <style>
        /* Estilos responsivos personalizados */
        @media (max-width: 768px) {
            .content-header {
                flex-direction: column !important;
                align-items: flex-start !important;
            }
            .content-header h1 {
                margin-bottom: 10px;
            }
            .btn-add-libro {
                width: 100%;
            }
            .table-responsive {
                font-size: 0.9rem;
            }
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                text-align: left !important;
            }
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }
        /* Ajustes para columnas pequeñas */
        @media (max-width: 576px) {
            .table-responsive {
                font-size: 0.8rem;
            }
            .btn-sm {
                padding: 0.2rem 0.4rem;
                font-size: 0.7rem;
            }
        }
    </style>
@stop

@section('content_header')
    <div class="content-header d-flex justify-content-between align-items-center">
        <h1 class="mb-0">
            <i class="bi bi-book-fill me-2"></i>Lista de Libros
        </h1>
        <a href="{{ route('libros.create') }}" class="btn btn-primary btn-add-libro">
            <i class="fas fa-plus"></i> Añadir Nuevo Libro
        </a>
    </div>
@stop

@section('content')
    <div class="card container-fluid p-0">
        <div class="card-header">
            <h3 class="card-title text-center">Libros Registrados</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="librosTable" class="table table-striped table-bordered text-center w-100">
                    <thead>
                        <tr>
                            <th><i class="bi bi-person-badge-fill"></i> N° Libro</th>
                            <th><i class="bi bi-calendar-fill"></i> Fecha Inicio</th>
                            <th><i class="bi bi-calendar-event-fill"></i> Fecha Final</th>
                            <th><i class="bi bi-file-earmark-text-fill"></i> Descripción</th>
                            <th><i class="bi bi-save-fill"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($libros as $libro)
                        <tr>
                            <td>{{ $libro->id_Libros }}</td>
                            <td>{{ $libro->fechainicio_Libro }}</td>
                            <td>{{ $libro->fechafinal_Libro }}</td>
                            <td>
                                <div style="max-width: 350px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $libro->descripcion_Libro }}
                                </div>
                            </td>
                            <td class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-1">
                                <a href="{{ route('libros.show', $libro->id_Libros) }}" 
                                   class="btn btn-info btn-sm" 
                                   title="Ver este libro">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <a href="{{ route('libros.edit', $libro->id_Libros) }}" 
                                   class="btn btn-warning btn-sm" 
                                   title="Editar este libro">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form action="{{ route('libros.destroy', $libro->id_Libros) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      id="deleteForm-{{ $libro->id_Libros }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm" 
                                            onclick="return Eliminar(event, 'deleteForm-{{ $libro->id_Libros }}');" 
                                            title="Eliminar este libro">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                                @if (date('n') == 12)
                                    <a href="{{ route('libros.edit', $libro->id_Libros) }}" 
                                       class="btn btn-secondary btn-sm" 
                                       title="Cerrar este libro">
                                        <i class="bi bi-lock"></i> Cerrar
                                    </a>
                                @else
                                    <button type="button" 
                                            class="btn btn-secondary btn-sm" 
                                            title="No disponible" 
                                            disabled>
                                        <i class="bi bi-unlock"></i> No disponible
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
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
                "responsive": true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                initComplete: function() {
                    $('.dataTables_filter input').attr('placeholder', 'Buscar registros...');
                    $('.dataTables_filter input').addClass('form-control');
                    $('.dataTables_length select').addClass('form-select');
                }
            });
        });

        function Eliminar(event, formId) {
            event.preventDefault();
            Swal.fire({
                icon: 'question',
                title: '¿Confirmar eliminación del libro?',
                text: 'Esta acción no se puede deshacer. ¿Está seguro de que desea eliminar este libro?',
                confirmButtonText: 'Sí, eliminar',
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

    <!-- Alertas de éxito y error -->
    @if(session('success_delete'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Operación exitosa!',
            text: "El libro se ha eliminado correctamente. No podrá ser recuperado.",
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
    @endif

    @if(session('success_update'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Operación exitosa!',
            text: "El libro se ha actualizado correctamente. Puedes ver los cambios en la lista de libros.",
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
    @endif

    @if(session('success_create'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Operación exitosa!',
            text: "El libro se ha creado correctamente. Puedes verlo en la lista de libros.",
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
    @endif
    
    <!-- Alertas de error -->

    @if(session('error_create'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: "Hubo un problema al crear el libro. Verifica que hayas ingresado todos los campos obligatorios y que el libro no se encuentre duplicado. Inténtalo de nuevo.",
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });
    </script>
    @endif

    @if(session('error_update'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: "Hubo un problema al actualizar el libro. Verifica que hayas ingresado todos los campos obligatorios y que el libro no se encuentre duplicado. Inténtalo de nuevo.",
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });
    </script>
    @endif

    @if(session('error_delete'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: "Hubo un problema al eliminar el libro. Verifica que no tenga actas asociadas y que no esté en uso en el sistema. Inténtalo de nuevo.",
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });
    </script>
    @endif
@stop