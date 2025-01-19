@extends('adminlte::page')

@section('title', 'Detalles del Acta')

@section('content_header')
<h1><i class="bi bi-file-earmark-text-fill me-2"></i>Detalles del Acta</h1>

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
        <h5 class="mb-0" aria-label="Información detallada del acta">📋 Información del Acta</h5>
    </div>
    <!-- Cuerpo de la tarjeta -->
    <div class="card-body p-3">
        <!-- Sección: ID Acta e ID Libro -->
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong><i class="fas fa-id-badge" aria-hidden="true"></i> ID Acta:</strong></p>
                <div class="bg-light rounded p-2">
                    <span id="id_acta" class="text-muted" aria-label="Número de identificación del acta">{{ $acta->id_Actas }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong><i class="fas fa-handshake" aria-hidden="true"></i> Tipo de sesión:</strong></p>
                <div class="bg-light rounded p-2">
                    <span id="id_tipo_sesion" class="text-muted" aria-label="Tipo de sesión del acta">{{ $acta->tipo_sesion }}</span>
                </div>
            </div>
        </div>

        <!-- Sección: Descripción -->
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong><i class="fas fa-info-circle" aria-hidden="true"></i> Descripción del acta:</strong></p>
                <div class="bg-light rounded p-3">
                    <span id="descripcion" class="text-muted" aria-label="Descripción detallada del acta">
                        {{ $acta->descripcion ?: 'Sin descripción' }}
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong><i class="fas fa-hashtag" aria-hidden="true"></i> Correlativo:</strong></p>
                <div class="bg-light rounded p-2">
                    <span id="correlativo" class="text-muted" aria-label="Número correlativo del acta">
                        {{ $acta->correlativo ?: 'No asignado' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Sección: Contenido Elaboración -->
        <div class="row mb-3">
            <div class="col-12">
                <p class="mb-1"><strong><i class="fas fa-book-open" aria-hidden="true"></i> Contenido elaboración: </strong></p>
                <textarea class="form-control" name="contenido_elaboracion" id="contenido_elaboracion" aria-label="Contenido detallado de la elaboración">
                    {!! $acta->contenido_elaboracion ? htmlspecialchars_decode(e($acta->contenido_elaboracion)) : 'Sin contenido de elaboración' !!}
                </textarea>
            </div>
        </div>

        <!-- Sección: Presentes y Ausentes -->
        <div class="card shadow-sm mb-3">
            <div class="card-body bg-light">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><i class="fas fa-user-check" aria-hidden="true"></i> <strong>Miembros presentes en la sesión:</strong></p>
                        <div class="bg-light rounded shadow-sm p-3">
                            @php
                                $presentes = array_filter(explode(',', $acta->presentes));
                            @endphp
                            @if(!empty($presentes))
                                <ol id="lista-presentes" class="list-group list-group-numbered" style="max-height: 150px; overflow-y: auto;">
                                    @foreach ($presentes as $presente)
                                    <li class="list-group-item">
                                        <i class="fas fa-user-check me-2" style="color: #0062cc;" aria-hidden="true"></i>
                                        {{ trim($presente) }}
                                    </li>
                                    @endforeach
                                </ol>
                                <button class="btn btn-link p-0 mt-2 toggle-button" data-target="lista-presentes" onclick="toggleList(this)">Mostrar más</button>
                            @else
                                <p class="text-muted">No hay miembros presentes registrados.</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1"><i class="fas fa-user-times" aria-hidden="true"></i> <strong>Miembros ausentes en la sesión:</strong></p>
                        <div class="bg-light rounded shadow-sm p-3">
                            @php
                                $ausentes = array_filter(explode(',', $acta->ausentes));
                            @endphp
                            @if(!empty($ausentes))
                                <ol id="lista-ausentes" class="list-group list-group-numbered" style="max-height: 150px; overflow-y: auto;">
                                    @foreach ($ausentes as $ausente)
                                    <li class="list-group-item">
                                        <i class="fas fa-user-times me-2" style="color: #dc3545;" aria-hidden="true"></i>
                                        {{ trim($ausente) }}
                                    </li>
                                    @endforeach
                                </ol>
                                <button class="btn btn-link p-0 mt-2 toggle-button" data-target="lista-ausentes" onclick="toggleList(this)">Mostrar más</button>
                            @else
                                <p class="text-muted">No hay miembros ausentes registrados.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: Fecha y Estado -->
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong><i class="fas fa-calendar-alt" aria-hidden="true"></i> Fecha:</strong></p>
                <div class="bg-light rounded p-2">
                    <span id="fecha" class="text-muted" aria-label="Fecha del acta">
                        {{ $acta->fecha ?: 'Fecha no especificada' }}
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong><i class="fas fa-calendar-alt" aria-hidden="true"></i> Estado:</strong></p>
                <div class="bg-light rounded p-2">
                    <span id="estado" class="text-muted" aria-label="Estado actual del acta">
                        {{ $acta->estado ?: 'Estado no definido' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Sección: Motivo de Inasistencia -->
        <div class="mb-3">
            <p class="mb-1"><strong><i class="fas fa-book-open" aria-hidden="true"></i> Motivo de inasistencia del personal no presente en la sesión:</strong></p>
            <div class="bg-light rounded p-3" style="max-height: 200px; overflow-y: auto;">
                <span id="motivo_ausencia" class="text-muted" aria-label="Motivos de inasistencia">
                    {!! $acta->motivo_ausencia ? htmlspecialchars_decode(e($acta->motivo_ausencia)) : 'Sin motivos de inasistencia registrados' !!}
                </span>
            </div>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-left">
            <a href="{{ route('actas.index') }}" class="btn btn-secondary px-4 py-2 rounded-pill shadow-sm me-2" aria-label="Volver a la lista de actas">
                <i class="fas fa-arrow-left" aria-hidden="true"></i> Atrás
            </a>
            <button id="export-pdf" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm" aria-label="Descargar acta en formato PDF">
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
    // Función para alternar listas de miembros
    function toggleList(button) {
        const list = document.getElementById(button.dataset.target);
        const isExpanded = list.style.maxHeight !== '';
        
        list.style.maxHeight = isExpanded ? '' : '150px';
        button.setAttribute('aria-expanded', !isExpanded);
        button.innerText = isExpanded ? 'Mostrar más' : 'Mostrar menos';
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar Summernote con opciones de accesibilidad
        $('#contenido_elaboracion').summernote({
            height: 280,
            lang: 'es-ES', // Soporte de idioma español
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
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
                        'aria-label': 'Editor de contenido de elaboración'
                    });
                }
            }
        });
    });
</script>
@stop