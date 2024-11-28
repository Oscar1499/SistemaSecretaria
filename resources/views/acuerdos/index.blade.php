@extends('adminlte::page')

@section('title', 'Listado de Acuerdos')

@section('content_header')
<h1>Listado de Acuerdos</h1>
<a href="{{ route('acuerdos.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Crear Nuevo Acuerdo
</a>
@stop
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<body>

</body>
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Acuerdos Registrados</h3>
    </div>
    <div class="card-body">
        <table id="acuerdosTable" class="table table-bordered table-hover w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Acta</th>
                    <th>ID Personal</th>
                    <th>Fecha de Acuerdo</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($acuerdos as $acuerdo)
                <tr>
                    <td>{{ $acuerdo->id_Acuerdo }}</td>
                    <td>{{ $acuerdo->id_Actas }}</td>
                    <td>{{ $acuerdo->id_Personal }}</td>
                    <td>{{ $acuerdo->fecha_Acuerdos }}</td>
                    <td>{{ $acuerdo->descripcion_Acuerdos }}</td>
                    <td>
                        <a href="#" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> ver</a>
                        <a href="#" class="btn btn-danger btn-sm"><i class="bi bi-pencil"></i> Editar</a>
                        <form action="{{ route('acuerdos.destroy', $acuerdo->id_Acuerdo) }}" method="POST" style="display:inline;" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return Eliminar(event);"><i class="bi bi-trash"></i> Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Alerta de éxito de Eliminado-->
@if(session('delete'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Operación exitosa!',
        text: "El acuerdo ha sido eliminado correctamente.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 3000,
        toast: true,
        position: 'top-end'
    });
</script>

@endif
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Operación exitosa!',
        text: "El acuerdo ha sido ingresado correctamente.",
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