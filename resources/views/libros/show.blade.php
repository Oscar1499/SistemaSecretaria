@extends('adminlte::page')

@section('title', 'Detalles del Libro')

@section('content_header')
    <h1><i class="fas fa-book"></i> Detalles del Libro</h1>
@stop

@section('content')
    <div class="container-fluid" style="border-radius: 10px;">
        <div class="shadow-lg border-0">
            <!-- Encabezado -->
            <div class="card-header bg-gradient-primary text-white">
                <h5 class="text-center mb-0">📚 Información del Libro</h5>
            </div>
            <!-- Cuerpo de la tarjeta -->
            <div class="card-body p-4">
                <!-- Fechas -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p class="mb-1"><strong><i class="fas fa-calendar-alt"></i> Fecha de Inicio:</strong></p>
                        <div class="bg-light rounded p-2">
                            <span id="fechainicio_Libro" class="text-muted">{{ $libro->fechainicio_Libro }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong><i class="fas fa-calendar-alt"></i> Fecha Final:</strong></p>
                        <div class="bg-light rounded p-2">
                            <span id="fechafinal_Libro" class="text-muted">{{ $libro->fechafinal_Libro }}</span>
                        </div>
                    </div>
                </div>
                <!-- Descripción -->
                <div class="row mb-4">
                    <div class="col-12">
                        <p class="mb-1"><strong><i class="fas fa-info-circle"></i> Descripción:</strong></p>
                        <div class="bg-light rounded p-3">
                            <span id="descripcion_Libro" class="text-muted">
                                {{ $libro->descripcion_Libro }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Apertura (con Desplazamiento o Colapsable) -->
                <div class="row mb-4">
                    <div class="col-12">
                        <p class="mb-1"><strong><i class="fas fa-book-open"></i> Apertura:</strong></p>

                        <!-- Opción 1: Contenedor con desplazamiento -->
                        <div class="bg-light rounded p-3" style="max-height: 200px; overflow-y: auto;">
                            <span id="apertura_Libro" class="text-muted">
                            {!! htmlspecialchars_decode(e($libro->apertura_Libro)) !!}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Botón de regreso -->
                <div class="mt-3">
                    <a href="{{ route('libros.index') }}" class="btn btn btn-secondary px-4 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-arrow-left"></i> Atrás
                    </a>
                    <a href="#" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-print mr-2"></i> Imprimir
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop
