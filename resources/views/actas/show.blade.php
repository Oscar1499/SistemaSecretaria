@extends('adminlte::page')

@section('title', 'Detalles del Acta')

@section('content_header')
<h1>Detalles del Acta</h1>
@stop

@section('content')
    <div class="shadow-lg border-0">
        <!-- Encabezado -->
        <div class="card-header bg-gradient-primary text-white text-center">
            <h5 class="mb-0">📋 Información del Acta</h5>
        </div>
        <!-- Cuerpo de la tarjeta -->
        <div class="card-body p-4">
            <!-- Sección: ID Acta e ID Libro -->
            <div class="row mb-4">
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
            <div class="row mb-4">
                <div class="col-12">
                    <p class="mb-1"><strong><i class="fas fa-info-circle"></i> Descripción del acta:</strong></p>
                    <div class="bg-light rounded p-3">
                        <span id="descripcion" class="text-muted">{{ $acta->descripcion }}</span>
                    </div>
                </div>
            </div>

            <!-- Sección: Contenido Elaboración -->
            <div class="row mb-4">
                <div class="col-12">
                    <p class="mb-1"><strong><i class="fas fa-book-open"></i> Contenido elaboración: </strong></p>
                    <div class="bg-light rounded p-3" style="max-height: 200px; overflow-y: auto;">
                        <span id="contenido_elaboracion" class="text-muted">
                            {!! htmlspecialchars_decode(e($acta->contenido_elaboracion)) !!}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Sección: Presentes y Ausentes -->
            <div class="bg-light  mb-4">
                <div class="card shadow-sm">
                    <div class="card-body bg-light">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1 " >
                                    <i class="fas fa-user-check"></i> <strong>Miembros presentes en la sesión:</strong>
                                </p>
                                <div class="bg-light rounded shadow-sm p-3">
                                    <ol id="lista-presentes" class="list-group list-group-numbered" style="max-height: 150px; overflow-y: auto;">
                                        @foreach (explode(',', $acta->presentes) as $presente)
                                        <li class="list-group-item">
                                            <i class="fas fa-user-check me-2" style="color: #0062cc;"></i>
                                            {{ $presente }}
                                        </li>
                                        @endforeach
                                    </ol>
                                    <button class="btn btn-link p-0 mt-2 toggle-button" data-target="lista-presentes">Mostrar más</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 " >
                                    <i class="fas fa-user-times" ></i> <strong> Miembros ausentes en la sesión: </strong>
                                </p>
                                <div class="bg-light rounded shadow-sm p-3">
                                    <ol id="lista-ausentes" class="list-group list-group-numbered" style="max-height: 150px; overflow-y: auto;">
                                        @foreach (explode(',', $acta->ausentes) as $ausente)
                                        <li class="list-group-item">
                                            <i class="fas fa-user-times me-2" style="color: #dc3545;"></i>
                                            {{ $ausente }}
                                        </li>
                                        @endforeach
                                    </ol>
                                    <button class="btn btn-link p-0 mt-2 toggle-button" data-target="lista-ausentes">Mostrar más</button>
                                </div>
                            </div>

                            <script>
                                document.querySelectorAll('.toggle-button').forEach(button => {
                                    button.addEventListener('click', function() {
                                        const targetId = this.getAttribute('data-target');
                                        const targetList = document.getElementById(targetId);
                                        if (targetList.style.maxHeight === 'none') {
                                            targetList.style.maxHeight = '150px';
                                            this.textContent = 'Mostrar más';
                                        } else {
                                            targetList.style.maxHeight = 'none';
                                            this.textContent = 'Mostrar menos';
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección: Fecha y Correlativo -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="mb-1"><strong><i class="fas fa-calendar-alt"></i> Fecha:</strong></p>
                    <div class="bg-light rounded p-2">
                        <span id="fecha" class="text-muted">{{ $acta->fecha }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong><i class="fas fa-hashtag"></i> Correlativo:</strong></p>
                    <div class="bg-light rounded p-2">
                        <span id="correlativo" class="text-muted">{{ $acta->correlativo }}</span>
                    </div>
                </div>
            </div>

            <!-- Sección: Motivo de Inasistencia -->
            <div class="mb-4">
                <p class="mb-1"><strong><i class="fas fa-book-open"></i> Motivo de inasistencia del personal no presente en la sesión:</strong></p>
                <div class="bg-light rounded p-3" style="max-height: 200px; overflow-y: auto;">
                    <span id="contenido_acta" class="text-muted">{!! htmlspecialchars_decode(e($acta->motivo_ausencia)) !!}</span>
                </div>
            </div>

             <!-- Sección: id_Personal
             <div class="mb-4">
                <p class="mb-1"><strong><i class="fas fa-book-open"></i>ID_Personal</strong></p>
                <div class="bg-light rounded p-3" style="max-height: 200px; overflow-y: auto;">
                    <span id="contenido_acta" class="text-muted">{{ $acta->id_Personal }}</span>
                </div>
            </div> -->

            <!-- Botones -->
            <a href="{{ route('actas.index') }}" class="btn btn-secondary px-4 py-2 rounded-pill shadow-sm me-2">
                <i class="fas fa-arrow-left"></i> Atrás
            </a>
            <a href="#" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm">
                <i class="fas fa-print"></i> Imprimir
            </a>
        </div>
    </div>
</div>
@stop
