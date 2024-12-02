@extends('adminlte::page')

@section('title', 'Crear Nuevo Acuerdo')

@section('content_header')
<h1>Crear Nuevo Acuerdo</h1>
@stop

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<body>

</body>
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="card-body">
                <!-- Barra de Progreso -->
                <div class="progress mb-4">
                    <div
                        class="progress-bar progress-bar-striped progress-bar-animated"
                        role="progressbar"
                        style="width: 33%;"
                        id="progress-bar"
                        aria-valuenow="33"
                        aria-valuemin="0"
                        aria-valuemax="100">
                        <span>Paso 1 de 3</span> <!-- Añadir el span para el texto -->
                    </div>
                </div>
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
                                    <label for="id_Actas"><i class="bi bi-journal-bookmark-fill"></i> Acta</label>
                                    <select id="id_Actas" name="id_Actas" class="form-control select2" required>
                                        <option value="" disabled selected>Seleccione un Acta</option>
                                        @foreach($actas as $acta)
                                        <option value="{{ $acta->id }}|{{ $acta->descripcion_acta }}">
                                            {{ $acta->id_Actas }} - {{ $acta->descripcion }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary next-step">Siguiente <i class="bi bi-arrow-right"></i></button>
                            </div>

                            <!-- Paso 2: Redactar el Memorando -->
                            <div id="step-2" class="content" role="tabpanel" aria-labelledby="stepper-step-2">
                                <div class="form-group">
                                    <label for="descripcion_Acuerdos"><i class="bi bi-journal-plus"></i> Descripción del Acuerdo</label>
                                    <textarea class="form-control" id="descripcion_Acuerdos" name="descripcion_Acuerdos" required></textarea>
                                </div>


                                <button type="button" class="btn btn-secondary previous-step"><i class="bi bi-arrow-left"></i> Atrás</button>
                                <button type="button" class="btn btn-primary next-step">Siguiente <i class="bi bi-arrow-right"></i></button>
                            </div>

                            <!-- Paso 3: Seleccionar Personal -->
                            <div id="step-3" class="content" role="tabpanel" aria-labelledby="stepper-step-3">
                                <div class="form-group">
                                    <label for="id_Personal"><i class="bi bi-people-fill"></i> Personal</label>
                                    <select id="id_Personal" name="id_Personal" class="form-control select2" required>
                                        <option value="" disabled selected>Seleccione el Personal</option>
                                        @foreach($personal as $persona)
                                        <option value="{{ $persona->id }}" data-nombre="{{ $persona->nombre }} {{ $persona->apellido }}">
                                            {{ $persona->nombre }} {{ $persona->apellido }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <p id="porcentaje-favor">0% a favor</p>
                                    <p id="porcentaje-contra">0% en contra</p>
                                </div>


                                <button type="button" class="btn btn-primary" id="todos-a-favor"><i class="bi bi-hand-thumbs-up me-2"></i> Todos a Favor</button>

                                <!-- Tabla para mostrar los votos -->
                                <table class="table table-bordered mt-3" id="tabla-votos">
                                    <thead>
                                        <tr>
                                            <th>Personal</th>
                                            <th>Voto</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>

                                <button type="button" class="btn btn-secondary previous-step"><i class="bi bi-arrow-left"></i> Atrás</button>
                                <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Guardar Acuerdo</button>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const nextButtons = document.querySelectorAll('.next-step');
            const prevButtons = document.querySelectorAll('.previous-step');
            const progressBar = document.getElementById('progress-bar');
            const progressBarText = progressBar.querySelector('span');
            const steps = document.querySelectorAll('.step');
            const totalSteps = steps.length;
            let currentStep = 0;

            // Actualizar barra de progreso
            function updateProgressBar() {
                const stepWidth = (100 / totalSteps) * (currentStep + 1);
                progressBar.style.width = `${stepWidth}%`;
                progressBar.setAttribute('aria-valuenow', stepWidth);
                progressBarText.textContent = `Paso ${currentStep + 1} de ${totalSteps}`;
            }

            function showStep(stepIndex) {
                steps.forEach((step, index) => {
                    const stepContent = document.querySelector(step.getAttribute('data-target'));

                    if (index === stepIndex) {
                        step.classList.add('active', 'active-step');
                        stepContent.style.display = 'block';
                    } else {
                        step.classList.remove('active', 'active-step');
                        stepContent.style.display = 'none';
                    }
                });

                updateProgressBar(); // Actualiza la barra de progreso
            }

            // Botón "Siguiente"
            nextButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (currentStep < totalSteps - 1) {
                        currentStep++;
                        showStep(currentStep);
                    }
                });
            });

            // Botón "Atrás"
            prevButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (currentStep > 0) {
                        currentStep--;
                        showStep(currentStep);
                    }
                });
            });

            // Inicializar en el primer paso
            showStep(currentStep);
        });
    </script>
    <style>
        .step .bs-stepper-circle {
            background-color: #ccc;
            /* Color por defecto */
            color: #fff;
        }

        .active-step .bs-stepper-circle {
            background-color: #007bff;
            /* Azul cuando está activo */
            color: #fff;
        }

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var stepper = new Stepper(document.querySelector('.bs-stepper'));

            document.querySelectorAll('.next-step').forEach(button => {
                button.addEventListener('click', () => stepper.next());
            });
            document.querySelectorAll('.previous-step').forEach(button => {
                button.addEventListener('click', () => stepper.previous());
            });

            $('.select2').select2();

            $('#descripcion_Acuerdos').summernote({
                height: 200,
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
                ]
            });

            let votos = {}; // Almacena los votos por ID
            let totalFavor = 0;
            let totalContra = 0;
            const tablaVotos = document.querySelector('#tabla-votos tbody');
            const porcentajeFavor = document.querySelector('#porcentaje-favor');
            const porcentajeContra = document.querySelector('#porcentaje-contra');

            function actualizarPorcentajes() {
                const totalVotos = totalFavor + totalContra;
                const favor = totalVotos ? ((totalFavor / totalVotos) * 100).toFixed(2) : 0;
                const contra = totalVotos ? ((totalContra / totalVotos) * 100).toFixed(2) : 0;

                porcentajeFavor.textContent = `${favor}% a favor`;
                porcentajeContra.textContent = `${contra}% en contra`;
            }

            function actualizarTabla() {
                tablaVotos.innerHTML = '';
                Object.keys(votos).forEach(id => {
                    const {
                        nombre,
                        voto
                    } = votos[id];
                    const fila = `
                <tr>
                    <td>${nombre}</td>
                    <td>${voto}</td>
                    <td>
                        <button class="btn btn-danger btn-sm eliminar-voto" data-id="${id}"><i class="bi bi-trash me-2"></i>Eliminar</button>
                    </td>
                </tr>`;
                    tablaVotos.innerHTML += fila;

                });

                document.querySelectorAll('.eliminar-voto').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.dataset.id;
                        const voto = votos[id]?.voto;

                        if (voto === 'A favor') totalFavor--;
                        if (voto === 'En contra') totalContra--;

                        delete votos[id];
                        actualizarTabla();
                        actualizarPorcentajes();
                    });
                });
            }

            if (typeof Swal === 'undefined') {
                console.error('SweetAlert2 no está disponible.');
                return;
            }

            $('#id_Personal').on('select2:select', function(e) {
                const data = e.params.data;
                const id = parseInt(data.id);
                const nombre = data.element.dataset.nombre;

                if (votos[id]) {
                    Swal.fire('Error', 'Ya se ha votado por esta persona.', 'error');
                    $(this).val(null).trigger('change');
                    return;
                }

                if (id === 1) {
                    Swal.fire({
                        text: '¿Quieres usar el voto doble o simple?',
                        icon: 'question',
                        showDenyButton: true,
                        confirmButtonText: 'Voto Doble',
                        denyButtonText: 'Voto Simple',
                    }).then(result => {
                        const votosTotal = result.isConfirmed ? 2 : 1;

                        Swal.fire({
                            text: '¿El voto es a favor o en contra?',
                            icon: 'question',
                            showDenyButton: true,
                            confirmButtonText: 'A favor',
                            denyButtonText: 'En contra',
                        }).then(result2 => {
                            const decision = result2.isConfirmed ? 'A favor' : 'En contra';

                            if (decision === 'A favor') totalFavor += votosTotal;
                            if (decision === 'En contra') totalContra += votosTotal;

                            votos[id] = {
                                nombre,
                                voto: `${decision} (${votosTotal})`
                            };
                            actualizarTabla();
                            actualizarPorcentajes();
                            $('#id_Personal').val(null).trigger('change');
                        });
                    });
                } else {
                    Swal.fire({
                        text: '¿El voto es a favor o en contra?',
                        icon: 'question',
                        showDenyButton: true,
                        confirmButtonText: 'A favor',
                        denyButtonText: 'En contra',
                    }).then(result => {
                        const decision = result.isConfirmed ? 'A favor' : 'En contra';

                        if (decision === 'A favor') totalFavor++;
                        if (decision === 'En contra') totalContra++;

                        votos[id] = {
                            nombre,
                            voto: decision
                        };
                        actualizarTabla();
                        actualizarPorcentajes();
                        $('#id_Personal').val(null).trigger('change');
                    });
                }
            });

            document.querySelector('#todos-a-favor').addEventListener('click', function() {
                $('#id_Personal option').each(function() {
                    const id = parseInt(this.value);
                    const nombre = this.dataset.nombre;

                    if (id && !votos[id]) { // Verificar si no existe el voto
                        const votosTotal = id === 1 ? 1 : 1; // La alcaldesa tiene voto simple
                        votos[id] = {
                            nombre,
                            voto: 'A favor'
                        };
                        totalFavor += votosTotal;
                    }
                });

                actualizarTabla();
                actualizarPorcentajes();
            });
        });
    </script>
    @stop