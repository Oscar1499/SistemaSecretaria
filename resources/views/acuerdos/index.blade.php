@extends('adminlte::page')

@section('title', 'Listado de Acuerdos')

@section('content_header')
<h1><i class="bi bi-book-fill me-2"></i>Listado de Acuerdos</h1>
<a href="{{ route('acuerdos.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Añadir Nuevo Acuerdo
</a>
@stop
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body>

</body>
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Acuerdos Registrados</h3>
    </div>
    <div class="card-body">
        <table id="acuerdosTable" class="table table-striped table-bordered table-hover text-center w-100">
            <thead>
                <tr>
                    <th><i class="bi1 bi-person-badge-fill"></i> ID</th>
                    <th><i class="bi1 bi-file-earmark-fill"></i> ID Acta</th>
                    <th><i class="bi1 bi-people-fill"></i> ID Personal</th>
                    <th><i class="bi1 bi-calendar-fill"></i> Fecha de Acuerdo</th>
                    <th><i class="bi1 bi-file-earmark-text-fill"></i> Descripción</th>
                    <th><i class="bi1 bi-save-fill"></i> Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($acuerdos as $acuerdo)
                <tr>
                    <td>{{ $acuerdo->id_Acuerdo }}</td>
                    <td>{{ $acuerdo->id_Actas }}</td>
                    <td>{{ $acuerdo->id_Personal }}</td>
                    <td>{{ $acuerdo->fecha_Acuerdos }}</td>
                    <td>{{ $acuerdo->descripcion_Acuerdos }}</td>
                    <td>
                        <a href="{{ route('acuerdos.show', $acuerdo->id_Acuerdo) }}" class="btn btn-info btn-sm" title="Ver este acuerdo"
                            data-bs-toggle="tooltip"><i class="bi bi-eye"></i> Ver</a>

                        <a href="{{ route('acuerdos.edit', $acuerdo->id_Acuerdo) }}" class="btn btn-warning btn-sm" title="Editar este acuerdo"
                            data-bs-toggle="tooltip"><i class="bi bi-pencil"></i> Editar</a>

                        <form action="{{ route('acuerdos.destroy', $acuerdo->id_Acuerdo) }}" method="POST" style="display:inline;" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return Eliminar(event);" title="Eliminar este acuerdo"

                                data-bs-toggle="tooltip"><i class="bi bi-trash"></i> Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Alerta de éxito de Exitos-->
@if(session('success_delete'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Acuerdo eliminado!',
        text: "El acuerdo ha sido eliminado correctamente. Puedes ver la lista de acuerdos actualizada.",
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
<script>
    function Eliminar(event) {

        event.preventDefault();

        // Mostrar SweetAlert
        Swal.fire({
            icon: 'question',
            title: '¿Confirmar eliminación del acuerdo?',
            text: 'Esta acción no se puede deshacer. ¿Está seguro de que desea eliminar este acuerdo?',
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
@stop

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#acuerdosTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            },
            "autoWidth": true,
            "responsive": true
        });
    });
</script>
@stop
