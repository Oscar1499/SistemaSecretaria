@extends('adminlte::page')

@section('title', 'Lista de Libros')

@section('content_header')
<h1>Libros</h1>
@stop

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<body>

</body>
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('libros.create') }}" class="btn btn-primary"> <i class="fas fa-plus"></i> Agregar Nuevo Libro</a>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead style="text-align: center;">
                <tr>
                    <th>ID</th>
                    <th>Año</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody style="text-align: center;">
                @foreach ($libros as $libro)

                <tr>
                    <td>{{ $libro->id_Libros }}</td>
                    <td>{{ $libro->anio }}</td>
                    <td>{{ $libro->descripcion_Libro }}</td>
                    <td>
                        <a href="{{ route('libros.show', $libro->id_Libros) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i> Ver</a>
                        <a href="{{ route('libros.edit',$libro->id_Libros) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i> Editar</a>
                        <form action="{{ route('libros.destroy', $libro->id_Libros) }}" method="POST" style="display:inline-block;" id="deleteForm">
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
    function Eliminar(event) {

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
                document.getElementById('deleteForm').submit();
            }
        });
    }
</script>