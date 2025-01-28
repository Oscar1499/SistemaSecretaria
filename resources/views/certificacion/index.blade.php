@extends('adminlte::page')

@section('title', 'Lista de Certificaciones')

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
            .btn-add-certificacion {
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
            <i class="bi bi-file-earmark-text-fill me-2"></i>Lista de Certificaciones
        </h1>
        <a href="{{ route('certificacion.create') }}" class="btn btn-primary btn-add-certificacion">
            <i class="fas fa-plus"></i> Añadir Nueva Certificación
        </a>
    </div>
@stop

@section('content')
    <div class="card container-fluid p-0">
        <div class="card-header">
            <h3 class="card-title text-center">Certificaciones Registradas</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="certificacionTable" class="table table-striped table-bordered text-center w-100">
                    <thead>
                        <tr>
                            <th><i class="bi bi-person-badge-fill"></i> ID</th>
                            <th><i class="bi bi-book-fill"></i> Libro</th>
                            <th><i class="bi bi-file-earmark-fill"></i> Acta</th>
                            <th><i class="bi bi-people-fill"></i> Acuerdos</th>
                            <th><i class="bi bi-calendar-fill"></i> Fecha de Certificación</th>
                            <th><i class="bi bi-save-fill"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-1">
                                <a href=""             
                                   class="btn btn-info btn-sm" 
                                   title="Ver esta Certificación">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <a href="" 
                                   class="btn btn-warning btn-sm" 
                                   title="Editar esta Certificación">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form action="" 
                                      method="POST" 
                                      class="d-inline" 
                                      id="">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm" 
                                            onclick=""                             
                                            title="Eliminar esta Certificación">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                   
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
            $('#certificacionTable').DataTable({
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
                title: '¿Confirmar eliminación de la Certificación?',
                text: 'Esta acción no se puede deshacer. ¿Está seguro de que desea eliminar esta Certificación?',
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

@if(session('success_create'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Certificación creada!',
        text: "La certificación ha sido ingresada correctamente. Puedes verla en la lista de certificaciones.",
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
        text: "La certificación se ha actualizado correctamente.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 3000,
        toast: true,
        position: 'top-end'
    });
</script>
@endif

@if(session('success_delete'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Operación exitosa!',
        text: "La certificación se ha eliminado correctamente.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 3000,
        toast: true,
        position: 'top-end'
    });
</script>
@endif

<!-- Alertas de posibles errores -->
@if(session('error_create'))
<script>
    Swal.fire({
        icon: 'error',
        title: '¡Error al crear la Certificación!',
        text: "Verifica que hayas ingresado todos los campos obligatorios y que la Certificación no se encuentre duplicada. Inténtalo de nuevo.",
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
        title: '¡Error al Actualizar la Certificación!',
        text: "Verifica que hayas ingresado todos los campos obligatorios y que la Certificación no se encuentre duplicada. Inténtalo de nuevo.",
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
        title: '¡Error al intentar eliminar!',
        text: "No se pudo eliminar la certificación. Asegúrate de que no está siendo usada en otra parte del sistema.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 5000,
        toast: true,
        position: 'top-end'
    });
</script>
@endif
@stop