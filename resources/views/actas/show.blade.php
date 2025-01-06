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
        <h5 class="mb-0">📋 Información del Acta</h5>
    </div>
    <!-- Cuerpo de la tarjeta -->
    <div class="card-body p-3">
        <!-- Sección: ID Acta e ID Libro -->
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong><i class="fas fa-id-badge"></i> ID Acta:</strong></p>
                <div class="bg-light rounded p-2">
                    <span id="id_acta" class="text-muted">{{ $acta->id_Actas }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong><i class="fas fa-handshake"></i> Tipo de sesión:</strong></p>
                <div class="bg-light rounded p-2">
                    <span id="id_tipo_sesion" class="text-muted">{{ $acta->tipo_sesion }}</span>
                </div>
            </div>
        </div>

        <!-- Sección: Descripción -->
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong><i class="fas fa-info-circle"></i> Descripción del acta:</strong></p>
                <div class="bg-light rounded p-3">
                    <span id="descripcion" class="text-muted">{{ $acta->descripcion }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong><i class="fas fa-hashtag"></i> Correlativo:</strong></p>
                <div class="bg-light rounded p-2">
                    <span id="correlativo" class="text-muted">{{ $acta->correlativo }}</span>
                </div>
            </div>
        </div>

        <!-- Sección: Contenido Elaboración -->
        <div class="row mb-3">
            <div class="col-12">
                <p class="mb-1"><strong><i class="fas fa-book-open"></i> Contenido elaboración: </strong></p>
                <textarea class="form-control" name="contenido_elaboracion" id="contenido_elaboracion">
                    {!! htmlspecialchars_decode(e($acta->contenido_elaboracion)) !!}
                </textarea>
            </div>
        </div>

        <!-- Sección: Presentes y Ausentes -->
        <div class="card shadow-sm mb-3">
            <div class="card-body bg-light">
                <div class="row">

                    <div class="col-md-6">
                        <p class="mb-1"><i class="fas fa-user-check"></i> <strong>Miembros presentes en la sesión:</strong></p>
                        <div class="bg-light rounded shadow-sm p-3">
                            <ol id="lista-presentes" class="list-group list-group-numbered" style="max-height: 150px; overflow-y: auto;">
                                @foreach (explode(',', $acta->presentes) as $presente)
                                <li class="list-group-item">
                                    <i class="fas fa-user-check me-2" style="color: #0062cc;"></i>
                                    {{ $presente }}
                                </li>
                                @endforeach
                            </ol>
                            <button class="btn btn-link p-0 mt-2 toggle-button" data-target="lista-presentes" onclick="toggleList(this)">Mostrar más</button>
                        </div>
                    </div>

                    <script>
                        function toggleList(button) {
                            const list = document.getElementById(button.dataset.target);
                            if (list.style.maxHeight) {
                                list.style.maxHeight = null;
                                button.innerText = "Mostrar menos";
                            } else {
                                list.style.maxHeight = "150px";
                                button.innerText = "Mostrar más";
                            }
                        }
                    </script>

                    <div class="col-md-6">
                        <p class="mb-1"><i class="fas fa-user-times"></i> <strong>Miembros ausentes en la sesión:</strong></p>
                        <div class="bg-light rounded shadow-sm p-3">
                            <ol id="lista-ausentes" class="list-group list-group-numbered" style="max-height: 150px; overflow-y: auto;">
                                @foreach (explode(',', $acta->ausentes) as $ausente)
                                <li class="list-group-item">
                                    <i class="fas fa-user-times me-2" style="color: #dc3545;"></i>
                                    {{ $ausente }}
                                </li>
                                @endforeach
                            </ol>
                            <button class="btn btn-link p-0 mt-2 toggle-button" data-target="lista-ausentes" onclick="toggleList(this)">Mostrar más</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sección: Fecha y Estado -->
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong><i class="fas fa-calendar-alt"></i> Fecha:</strong></p>
                <div class="bg-light rounded p-2">
                    <span id="fecha" class="text-muted">{{ $acta->fecha }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong><i class="fas fa-calendar-alt"></i> Estado:</strong></p>
                <div class="bg-light rounded p-2">
                    <span id="estado" class="text-muted">{{ $acta->estado }}</span>
                </div>
            </div>
        </div>

        <!-- Sección: Motivo de Inasistencia -->
        <div class="mb-3">
            <p class="mb-1"><strong><i class="fas fa-book-open"></i> Motivo de inasistencia del personal no presente en la sesión:</strong></p>
            <div class="bg-light rounded p-3" style="max-height: 200px; overflow-y: auto;">
                <span id="motivo_ausencia" class="text-muted">{!! htmlspecialchars_decode(e($acta->motivo_ausencia)) !!}</span>
            </div>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-left">
            <a href="{{ route('actas.index') }}" class="btn btn-secondary px-4 py-2 rounded-pill shadow-sm me-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <button id="export-pdf" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm">
                <i class="fas fa-file-pdf"></i> Descargar PDF
            </button>
        </div>
    </div>
</div>
@stop

@section('js')
<!-- Scripts adicionales -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

<script>
    $(document).ready(function() {
        $('#contenido_elaboracion').summernote({
            height: 280,
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
            callbacks: {}
        });
    });
</script>
@stop