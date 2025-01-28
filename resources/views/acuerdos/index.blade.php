@extends('adminlte::page')

@section('title', 'Lista de Acuerdos')

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
            .btn-add-acuerdo {
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
            <i class="bi bi-file-earmark-text-fill me-2"></i>Lista de Acuerdos
        </h1>
        <a href="{{ route('acuerdos.create') }}" class="btn btn-primary btn-add-acuerdo">
            <i class="fas fa-plus"></i> Añadir Nuevo Acuerdo
        </a>
    </div>
@stop

@section('content')
    <div class="card container-fluid p-0">
        <div class="card-header">
            <h3 class="card-title text-center">Acuerdos Registrados</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="acuerdosTable" class="table table-striped table-bordered text-center w-100">
                    <thead>
                        <tr>
                        <th><i class="bi1 bi-person-badge-fill"></i> ID</th>
                    <th><i class="bi1 bi-file-earmark-fill"></i> ID Acta</th>
                    <th><i class="bi1 bi-people-fill"></i> ID Personal</th>
                    <th><i class="bi1 bi-calendar-fill"></i> Fecha de Acuerdo</th>
                    <th><i class="bi1 bi-save-fill"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($acuerdos as $acuerdo)
                        <tr>
                        <td>{{ $acuerdo->id_Acuerdo }}</td>
                    <td>{{ $acuerdo->id_Actas }}</td>
                    <td>{{ $acuerdo->id_Personal }}</td>
                    <td>{{ $acuerdo->fecha_Acuerdos }}</td>
                            <td class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-1">
                                <a href="{{ route('acuerdos.show', $acuerdo->id_Acuerdo) }}"             
                                   class="btn btn-info btn-sm" 
                                   title="Ver este Acuerdo">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <a href="{{ route('acuerdos.edit', $acuerdo->id_Acuerdo) }}" 
                                   class="btn btn-warning btn-sm" 
                                   title="Editar este Acuerdo">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form action="{{ route('acuerdos.destroy', $acuerdo->id_Acuerdo) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      id="deleteForm-{{ $acuerdo->id_Acuerdo }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm" 
                                            onclick="return Eliminar(event, 'deleteForm-{{ $acuerdo->id_Acuerdo }}');"                             
                                            title="Eliminar este Acuerdo">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                              
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
            $('#acuerdosTable').DataTable({
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
                title: '¿Confirmar eliminación del Acuerdo?',
                text: 'Esta acción no se puede deshacer. ¿Está seguro de que desea eliminar este Acuerdo?',
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


<!-- Alertas de operación exitosa -->

@if(session('success_create'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Acuerdo creado!',
        text: "El acuerdo ha sido ingresado correctamente. Puedes verlo en la lista de acuerdos.",
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
        text: "El acuerdo se ha actualizado correctamente.",
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
        text: "El acuerdo se ha eliminado correctamente.",
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
        title: '¡Error al guardar el Acuerdo!',
        text: "Verifica que hayas ingresado todos los campos obligatorios y que el Acuerdo no se encuentre duplicado. Inténtalo de nuevo.",
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
        title: '¡Error al Actualizar el Acuerdo!',
        text: "Verifica que hayas ingresado todos los campos obligatorios y que el Acuerdo no se encuentre duplicado. Inténtalo de nuevo.",
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
        text: "No se pudo eliminar el acuerdo. Asegúrate de que no está siendo usado en otra parte del sistema.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 5000,
        toast: true,
        position: 'top-end'
    });
</script>
@endif
@stop