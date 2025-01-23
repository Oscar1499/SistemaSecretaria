@extends('adminlte::page')

@section('title', 'Detalles del Acuerdo')

@section('content_header')
<h1><i class="bi bi-book-fill me-2"></i>Detalles del Acuerdo</h1>
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
                <p class="mb-1"><strong><i class="fas fa-info-circle" aria-hidden="true"></i> Estado:</strong></p>
                <div class="bg-light rounded p-2">
                    <span id="estado" class="text-muted" aria-label="Estado actual del acuerdo">
                        {{ $acuerdo->estado ?: 'Estado no definido' }}
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
        <p class="mb-2"><i class="fas fa-vote-yea" aria-hidden="true"></i> <strong>Detalles de Votación</strong></p>
        <div class="card shadow-sm mb-3">
            <div class="card-body bg-light">
                <div class="row">
            
                        <div class="bg-white rounded shadow-sm cold-12" style="max-height: 400px; overflow-y: auto;">
                            @php
                                $motivosVotacion = explode('|', $acuerdo->motivo_Votacion);
                                $motivosProcesados = [];
                                
                                foreach ($motivosVotacion as $motivo) {
                                    // Procesar cada entrada de votación
                                    $partes = explode(':', $motivo, 2);
                                    
                                    if (count($partes) >= 2) {
                                        $nombreCompleto = trim($partes[0]);
                                        $detallesVoto = trim($partes[1]);
                                        
                                        // Extraer información de voto y justificación
                                        $votoMatch = preg_match('/Voto=([^,]+)/', $detallesVoto, $matchVoto);
                                        $justificacionMatch = preg_match('/Justificación=(.+)/', $detallesVoto, $matchJustificacion);
                                        
                                        $voto = $votoMatch ? trim($matchVoto[1]) : 'Sin voto';
                                        $justificacion = $justificacionMatch ? trim($matchJustificacion[1]) : 'Sin justificación';
                                        
                                        // Eliminar el prefijo "En contra: " o "A favor: " si existe
                                        $justificacion = preg_replace('/^(En contra:|A favor:)\s*/', '', $justificacion);
                                        
                                        $motivosProcesados[] = [
                                            'nombre' => $nombreCompleto,
                                            'voto' => $voto,
                                            'justificacion' => $justificacion
                                        ];
                                    }
                                }
                            @endphp
                            
                            @if(!empty($motivosProcesados))
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="thead-light text-center">
                                            <tr>
                                                <th>Nombre y Cargo</th>
                                                <th>Voto</th>
                                                <th>Justificación</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($motivosProcesados as $motivo)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-user-tie me-2 text-primary"></i>
                                                            <strong>{{ $motivo['nombre'] }}</strong>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge {{ $motivo['voto'] == 'A favor' ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $motivo['voto'] }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="comment-container" style="max-height: 150px; overflow-y: auto; background-color: #f8f9fa; border-radius: 5px; padding: 8px;">
                                                            <small class="text-muted d-block">
                                                                <i class="fas fa-comment-dots me-1"></i>
                                                                {{ $motivo['justificacion'] }}
                                                            </small>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="mt-3 text-center">
                                    <div class="alert alert-info d-inline-block" role="alert">
                                        @php
                                            $totalVotantes = count($motivosProcesados);
                                            $votosAFavor = collect($motivosProcesados)->filter(function($motivo) {
                                                return $motivo['voto'] == 'A favor';
                                            })->count();
                                            $votosEnContra = collect($motivosProcesados)->filter(function($motivo) {
                                                return $motivo['voto'] == 'En contra';
                                            })->count();
                                        @endphp
                                        <div class="d-flex justify-content-center align-items-center">
                                            <div class="me-3">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Total de votantes: {{ $totalVotantes }}
                                            </div>
                                            <div class="me-3">
                                                <span class="badge bg-success me-1">
                                                    <i class="fas fa-check me-1"></i>
                                                    A Favor: {{ $votosAFavor }}
                                                </span>
                                            </div>
                                            <div>
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>
                                                    En Contra: {{ $votosEnContra }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning text-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    No se encontraron detalles de votación.
                                </div>
                            @endif
                        </div>
                   
                </div>
            </div>
        </div>


        <!-- Botones -->
        <div class="d-flex justify-content-left">
            <a href="{{ route('acuerdos.index') }}" class="btn btn-secondary px-4 py-2 rounded-pill shadow-sm me-2" aria-label="Volver a la lista de acuerdos">
                <i class="fas fa-arrow-left" aria-hidden="true"></i> Atrás
            </a>
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
                        'aria-label': 'Editor de descripción de acuerdos'
                    });
                }
            }
        });
    });
</script>
@stop