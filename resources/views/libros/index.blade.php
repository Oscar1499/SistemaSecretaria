@extends('adminlte::page')

@section('title', 'Lista de Libros')

@section('content_header')
<h1>Libros</h1>
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
        <a href="{{ route('libros.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Agregar Nuevo Libro
        </a>
    </div>
    <div class="card-body d-flex justify-content-center">
        <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                    <th><i class="bi1 bi-person-badge-fill"></i> ID</th>
                    <th><i class="bi1 bi-calendar-fill"></i> Fecha de inicio</th>
                    <th><i class="bi1 bi-calendar-event-fill"></i> Fecha de final</th>
                    <th><i class="bi1 bi-file-earmark-text-fill"> Descripción</th>
                    <th><i class="bi1 bi-save-fill"> Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($libros as $libro)
                <tr>
                    <td>{{ $libro->id_Libros }}</td>
                    <td>{{ $libro->fechainicio_Libro }}</td>
                    <td>{{ $libro->fechafinal_Libro }}</td>
                    <td>{{ $libro->descripcion_Libro }}</td>
                    <td>
                        <a href="{{ route('libros.show', $libro->id_Libros) }}" class="btn btn-info btn-sm" title="Ver este libro"

                            data-bs-toggle="tooltip">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('libros.edit', $libro->id_Libros) }}" class="btn btn-warning btn-sm" title="Editar este libro"

                            data-bs-toggle="tooltip">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('libros.destroy', $libro->id_Libros) }}" method="POST" class="d-inline-block" id="deleteForm-{{ $libro->id_Libros }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return Eliminar(event  , 'deleteForm-{{ $libro->id_Libros }}');" title="Eliminar este libro"

                                data-bs-toggle="tooltip">
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
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@if(session('success_Libro'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: "El libro se ha actualizado correctamente.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 3000,
        toast: true,
        position: 'top-end'
    });
</script>
@endif
@if(session('error_Libro'))
<script>
    Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: "Hubo un problema al editar el libro. Inténtalo de nuevo.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 5000,
        toast: true,
        position: 'top-end'
    });
</script>
@endif
<!-- Alerta de éxito de Eliminado-->
@if(session('delete'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: " El libro se ha eliminado correctamente.",
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

    function Eliminar(event, formId) {

        event.preventDefault();

        // Mostrar SweetAlert
        Swal.fire({
            icon: 'question',
            title: '¿Eliminar libro?',
            text: 'Esta acción no se puede deshacer. ¿Está seguro de eliminar este libro?',
            confirmButtonText: 'Sí, eliminarlo',
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
