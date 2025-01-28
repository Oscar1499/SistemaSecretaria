@extends('adminlte::page')

@section('title', 'Detalles del Acuerdo')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
<h1><i class="bi bi-book-fill me-2"></i>Detalles del Acuerdo</h1>
    <a href="{{ route('acuerdos.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle me-1"></i> Regresar
    </a>
</div>

@stop

@section('css')
<!-- Bootstrap Icons y estilos adicionales -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">
@stop

@section('content')
<div class="card container-fluid p-0">
    <div class="card-header bg-gradient-primary text-white text-center">
        <h5 class="mb-0" aria-label="Información detallada del acuerdo">📋 Información del Acuerdo</h5>
    </div>
    <!-- Cuerpo de la tarjeta -->
    <div class="card-body p-3">
        <!-- Sección: ID Acuerdo e ID Personal -->
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong><i class="fas fa-id-badge" aria-hidden="true"></i> ID Acuerdo:</strong></p>
                <div class="bg-light rounded p-2">
                    <span id="id_acuerdo" class="text-muted" aria-label="Número de identificación del acuerdo">{{ $acuerdo->id_Acuerdo }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong><i class="fas fa-user" aria-hidden="true"></i> ID Personal:</strong></p>
                <div class="bg-light rounded p-2">
                    <span id="id_personal" class="text-muted" aria-label="Identificador del personal asociado">{{ $acuerdo->id_Personal }}</span>
                </div>
            </div>
        </div>

        <!-- Sección: Descripción -->
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong><i class="fas fa-calendar-alt" aria-hidden="true"></i> Fecha del Acuerdo:</strong></p>
                <div class="bg-light rounded p-2">
                    <span id="fecha_acuerdos" class="text-muted" aria-label="Fecha de los acuerdos">
                        {{ $acuerdo->fecha_Acuerdos ?: 'Fecha no especificada' }}
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong><i class="fas fa-poll" aria-hidden="true"></i> Resultado de la Votación:</strong></p>
                <div class="bg-light rounded p-2">
                    <span id="resultado_votacion" class="text-muted" aria-label="Estado actual del acuerdo">
                        {{ $acuerdo->resultado_votacion}}
                    </span>
                </div>
            </div>
        </div>

        <!-- Sección: Descripción Detallada -->
        <div class="row mb-3">
            <div class="col-12">
                <p class="mb-1"><strong><i class="fas fa-book-open" aria-hidden="true"></i> Descripción del Acuerdo: </strong></p>
                <textarea class="form-control" name="descripcion_acuerdos" id="descripcion_acuerdos" aria-label="Contenido detallado del acuerdo">
                    {!! $acuerdo->descripcion_Acuerdos ? htmlspecialchars_decode(e($acuerdo->descripcion_Acuerdos)) : 'Sin descripción de acuerdos' !!}
                </textarea>
            </div>
        </div>

        <!-- Sección: Detalles Adicionales -->
        <div class="col-md-6">
                <p class="mb-1"><strong><i class="fas fa-info-circle" aria-hidden="true"></i> Estado:</strong></p>
                <div class="bg-light rounded p-2">
                    <span id="estado" class="text-muted" aria-label="Estado actual del acuerdo">
                        {{ $acuerdo->motivo_Votacion ?: 'Estado no definido' }}
                    </span>
                </div>
            </div>
        
        <!-- Botones -->
        <div class="d-flex justify-content-left">
            <button id="export-pdf" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm" aria-label="Descargar acuerdo en formato PDF">
                <i class="fas fa-file-pdf" aria-hidden="true"></i> Descargar PDF
            </button>
        </div>
    </div>
</div>
@stop

@section('js')
<!-- Scripts adicionales -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js" defer></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar Summernote con opciones de accesibilidad
        $('#descripcion_acuerdos').summernote({
            height: 300,
            lang: 'es-ES', // Soporte de idioma español
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onInit: function() {
                    // Añadir atributos de accesibilidad
                    $('.note-editable').attr({
                        'role': 'textbox',
                        'aria-multiline': 'true',
                        'aria-label': 'Editor de descripción de acuerdos'
                    });
                }
            }
        });
    });
</script>
@stop