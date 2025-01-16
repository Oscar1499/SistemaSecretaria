@extends('adminlte::page')

@section('title', 'Certificar Acuerdo')

@section('content_header')
    <h1><i class="fas fa-file-signature mr-2"></i> Certificar Acuerdo</h1>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@stop

@section('content')
    <div class="card container-fluid p-0">
        <div class="card-header">
            <h3 class="card-title text-center">Seleccione un acta para certificar</h3>
        </div>
        <div class="card-body">
            <table id="actasTable" class="table table-striped table-bordered table-hover text-center w-100">
                <thead>
                    <tr>
                        <th><i class="bi bi-person-badge-fill"></i> Libros</th>
                        <th><i class="bi bi-book-fill"></i> Actas</th>
                        <th><i class="bi bi-people-fill"></i> Acuerdos</th>
                        <th><i class="bi bi-calendar-fill"></i> Fecha</th>
                        <th><i class="bi bi-gear-fill"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <!-- Aqui inicia el bucle -->
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <a href="" class="btn btn-info btn-sm" title="Ver esta certificación" data-bs-toggle="tooltip">
                                <i class="bi bi-eye"></i> Ver Certificación
                            </a>
                            <a href="" class="btn btn-warning btn-sm" title="Certificar esta acta" data-bs-toggle="tooltip">
                                <i class="bi bi-pencil"></i> Certificar
                            </a>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return Eliminar(event, '');" title="Eliminar esta certificación" data-bs-toggle="tooltip">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <!-- Aqui termina el bucle -->
                </tbody>
            </table>
        </div>
    </div>
@stop