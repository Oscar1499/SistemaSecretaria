@extends('adminlte::page')
@section('title', 'Detalles Acuerdos')

@section('content_header')
<h1>Detalles del acuerdo</h1>
@stop

@section('content')
<div class="shadow-lg border-0">
        <!-- Encabezado -->
        <div class="card-header bg-gradient-primary text-white text-center">
            <h5 class="mb-0">📋 Información del acuerdo</h5>
        </div>

        <!-- Cuerpo de la tarjeta -->
        <div class="card-body p-4">
            <!-- Sección: ID Acta e ID Libro -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="mb-1"><strong><i class="fas fa-id-badge"></i> ID Acuerdo:</strong></p>
                    <div class="bg-light rounded p-2">
                        <span id="id_acta" class="text-muted">{{$acuerdo->id_Acuerdo}}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <p class="mb-1"><strong><i class="fas fa-hashtag"></i> ID Personal:</strong></p>
                    <div class="bg-light rounded p-2">
                        <span id="correlativo" class="text-muted">{{$acuerdo->id_Personal}}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <p class="mb-1"><strong><i class="fas fa-handshake"></i> Fecha de acuerdos:</strong></p>
                    <div class="bg-light rounded p-2">
                        <span id="id_tipo_sesion" class="text-muted">{{$acuerdo->fecha_Acuerdos}}</span>
                    </div>
                </div>
            </div>

            <!-- Sección: Descripción -->
            <div class="row mb-4">
                <div class="col-12">
                    <p class="mb-1"><strong><i class="fas fa-info-circle"></i> Descripción de acuerdos:</strong></p>
                    <div class="bg-light rounded p-3">
                        <span id="descripcion" class="text-muted">{{$acuerdo->descripcion_Acuerdos}}</span>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <a href="{{route('acuerdos.index')}}" class="btn btn-secondary px-4 py-2 rounded-pill shadow-sm me-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <a href="#" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm">
                <i class="fas fa-print"></i> Imprimir
            </a>
        </div>
    </div>
</div>
@stop
