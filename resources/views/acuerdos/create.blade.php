@extends('adminlte::page')

@section('title', 'Crear Nuevo Acuerdo')

@section('content_header')
    <h1>Crear Nuevo Acuerdo</h1>
@stop

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <!-- Stepper -->
                <div class="bs-stepper">
                    <div class="bs-stepper-header" role="tablist">
                        <!-- Paso 1 -->
                        <div class="step" data-target="#step-1">
                            <button type="button" class="step-trigger" role="tab" id="stepper-step-1" aria-controls="step-1">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Seleccionar Acta</span>
                            </button>
                        </div>
                        <div class="line"></div>

                        <!-- Paso 2 -->
                        <div class="step" data-target="#step-2">
                            <button type="button" class="step-trigger" role="tab" id="stepper-step-2" aria-controls="step-2">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">Redactar Memorando</span>
                            </button>
                        </div>
                        <div class="line"></div>

                        <!-- Paso 3 -->
                        <div class="step" data-target="#step-3">
                            <button type="button" class="step-trigger" role="tab" id="stepper-step-3" aria-controls="step-3">
                                <span class="bs-stepper-circle">3</span>
                                <span class="bs-stepper-label">Seleccionar Personal</span>
                            </button>
                        </div>
                    </div>

                    <div class="bs-stepper-content">
                        <!-- Formulario con pasos -->
                        <form action="{{ route('acuerdos.store') }}" method="POST">
                            @csrf

                            <!-- Paso 1: Seleccionar Acta -->
                            <div id="step-1" class="content" role="tabpanel" aria-labelledby="stepper-step-1">
                                <div class="form-group">
                                    <label for="id_Actas">Acta</label>
                                    <select id="id_Actas" name="id_Actas" class="form-control select2" required>
                                        <option value="" disabled selected>Seleccione un Acta</option>
                                        @foreach($actas as $acta)
                                            <option value="{{ $acta->id }}">{{ $acta->nombre_acta }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary next-step">Siguiente</button>
                            </div>

                            <!-- Paso 2: Redactar el Memorando -->
                            <div id="step-2" class="content" role="tabpanel" aria-labelledby="stepper-step-2">
              <div class="form-group">
    <label for="descripcion_Acuerdos">Descripción del Acuerdo</label>
    <textarea class="form-control" id="descripcion_Acuerdos" name="descripcion_Acuerdos" required></textarea>
</div>


                                <button type="button" class="btn btn-secondary previous-step">Atrás</button>
                                <button type="button" class="btn btn-primary next-step">Siguiente</button>
                            </div>

                            <!-- Paso 3: Seleccionar Personal -->
                            <div id="step-3" class="content" role="tabpanel" aria-labelledby="stepper-step-3">
                                <div class="form-group">
                                    <label for="id_Personal">Personal</label>
                                    <select id="id_Personal" name="id_Personal" class="form-control select2" required>
                                        <option value="" disabled selected>Seleccione el Personal</option>
                                        @foreach($personal as $persona)
                                            <option value="{{ $persona->id }}">{{ $persona->nombre }} {{ $persona->apellido }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" class="btn btn-secondary previous-step">Atrás</button>
                                <button type="submit" class="btn btn-success">Guardar Acuerdo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        /* Forzar que Select2 ocupe el 100% del ancho */
        .select2-container {
            width: 100% !important;
        }
        .select2-selection {
            height: calc(1.5em + .75rem + 2px) !important;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
    </style>
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar el stepper
            var stepper = new Stepper(document.querySelector('.bs-stepper'))

            // Funcionalidad para los botones de siguiente y anterior
            document.querySelectorAll('.next-step').forEach(button => {
                button.addEventListener('click', () => stepper.next())
            })
            document.querySelectorAll('.previous-step').forEach(button => {
                button.addEventListener('click', () => stepper.previous())
            })

            // Inicializar Select2
            $('.select2').select2();

            // Inicializar Summernote para el editor de texto enriquecido
            $('#descripcion_Acuerdos').summernote({
                height: 200, // Altura del editor
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']], // Herramienta para tablas
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
@stop
