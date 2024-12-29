@extends('adminlte::page')

@section('title', 'Editar Libro')

@section('content_header')
<h1><i class="bi bi-book-fill me-2"></i>  Editar Libro</h1>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

@stop

@section('content')
<!-- SweetAlert2 (para alertas) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- BS Stepper (para el paso a paso del formulario) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>

<!-- Select2 (para mejorar los selectores de formularios) -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- Bootstrap (framework de diseño) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Moment.js (para manejo de fechas y horas) -->
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

<!-- Flatpickr (para selección de fechas con calendario) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Bootstrap Icons (iconos adicionales para Bootstrap) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<body>

</body>
<div class="container">
    <div class="card">
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
                    Paso 1 de 2
                </div>
            </div>

            <!-- Stepper -->
            <div class="bs-stepper">
                <div class="bs-stepper-header" role="tablist">
                    <!-- Paso 1 -->
                    <div class="step" data-target="#step-1">
                        <button type="button" class="step-trigger" role="tab" id="stepper-step-1" aria-controls="step-1">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label">Configuración del libro</span>
                        </button>
                    </div>
                    <div class="line"></div>

                    <!-- Paso 2 -->
                    <div class="step" data-target="#step-3">
                        <button type="button" class="step-trigger" role="tab" id="stepper-step-3" aria-controls="step-3">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">Apertura del libro</span>
                        </button>
                    </div>
                </div>

                <div class="bs-stepper-content">
                    <!-- Formulario con pasos -->
                    <form action="{{ route('libros.update', $libro) }}" id="form-libro" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Paso 1: Configuración del libro-->
                        <div id="step-1" class="content active tab-pane" role="tabpanel" aria-labelledby="stepper-step-1">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="fecha">
                                        <i class="bi bi-calendar-event me-2"></i>
                                        Fecha de ingreso
                                    </label>

                                    <div class="input-group">
                                        <input oninput="validar_Step1()" type="date" class="form-control" id="fecha" name="fechainicio_Libro" value="{{ old('fechainicio_Libro', $libro->fechainicio_Libro) }}" required />
                                        <span class="input-group-text">
                                            <i class="bi bi-calendar-plus"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label for="fecha2">
                                        <i class="bi bi-calendar-x me-2"></i>
                                        Fecha de fin
                                    </label>

                                    <div class="input-group">
                                        <input type="date" oninput="validar_Step1()" class="form-control" id="fecha2" name="fechafinal_Libro" value="{{ old('fechafinal_Libro', $libro->fechafinal_Libro) }}" required />
                                        <span class="input-group-text">
                                            <i class="bi bi-calendar-plus"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group position-relative">

                                    <label for="descripcion_Acuerdos">
                                        <i class="bi bi-file-text me-2"></i>
                                        Descripción del libro
                                    </label>

                                    <textarea oninput="validar_Step1()"
                                        class="form-control input-with-icon"
                                        id="descripcion_Acuerdos"
                                        name="descripcion_Libro"
                                        placeholder="Escriba una descripción detallada del libro"
                                        rows="5"
                                        required>{{$libro->descripcion_Libro}}</textarea>
                                </div>

                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-primary next-step">Siguiente <i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>

                        {{-- Paso 2: Apertura del libro editar --}}
                        <div id="step-3" class="content" role="tabpanel" aria-labelledby="stepper-step-3">

                            <div class="form-group">
                                <label for="notas"><i class="bi bi-pencil-fill me-2"></i> Apertura del libro</label>
                                <textarea class="form-control" id="notas" name="apertura_Libro" required>{{$libro->apertura_Libro}}</textarea>
                            </div>

                            @section('css')
                            <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
                            @endsection

                            <!-- Botones de navegación -->
                            <div class="mt-3">
                                <button type="button" class="btn btn-secondary previous-step"><i class="bi bi-arrow-left"></i> Anterior</button>
                                <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Actualizar Libro</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        // Inicializar Summernote
        $('#notas').summernote({
            height: 400,
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
    });
</script>
@endsection

<script>
    // Inicializar Flatpickr para el campo de fecha
    flatpickr("#fecha", {
        dateFormat: "Y-m-d",
        allowInput: true,
        position: "auto",
        defaultDate: new Date(new Date().getFullYear(), 0, 1),
    });
</script>

<script>
    flatpickr("#fecha2", {
        dateFormat: "Y-m-d",
        allowInput: true,
        defaultDate: "2024-12-01",
        enable: [
            // Solo permitir fechas de diciembre
            function(date) {
                return date.getMonth() === 11;
            }
        ],
        onReady: function(selectedDates, dateStr, instance) {

            instance.jumpToDate(new Date(instance.currentYear, 11, 1));
            instance.calendarContainer.querySelectorAll(".flatpickr-monthDropdown-month, .flatpickr-prev-month, .flatpickr-next-month").forEach(el => {
                el.style.display = "none";
            });
        }
    });
</script>
<!-- Estilos personalizados -->
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

    .form-select {
        height: calc(1.5em + .75rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        width: 100%;
    }
</style>

<script>
    // Seleccionamos los botones de "Siguiente" y "Anterior"
    const nextButtons = document.querySelectorAll('.next-step');
    const previousButtons = document.querySelectorAll('.previous-step');

    // Función para cambiar al siguiente paso
    nextButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            let currentStep = e.target.closest('.content');
            let nextStep = currentStep.nextElementSibling;

            if (nextStep) {
                currentStep.classList.remove('active');
                nextStep.classList.add('active');

                updateActiveStep(nextStep);

                updateProgressBar();
            }
        });
    });

    // Función para volver al paso anterior
    previousButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            let currentStep = e.target.closest('.content');
            let previousStep = currentStep.previousElementSibling;

            if (previousStep) {

                currentStep.classList.remove('active');
                previousStep.classList.add('active');

                updateActiveStep(previousStep);

                updateProgressBar();
            }
        });
    });

    // Función para actualizar el paso activo en los botones
    function updateActiveStep(currentStep) {
        document.querySelectorAll('.step .step-trigger').forEach(button => {
            button.classList.remove('active-step');
        });

        const activeButton = document.querySelector(`#stepper-step-${currentStep.id.split('-')[1]}`);
        activeButton.classList.add('active-step');
    }

    // Función para actualizar la barra de progreso
    function updateProgressBar() {
        const steps = document.querySelectorAll('.content');
        const progressBar = document.getElementById('progress-bar');
        const activeStepIndex = Array.from(steps).findIndex(step => step.classList.contains('active'));

        // Aseguramos que siempre haya 2 pasos
        const totalSteps = 2;
        const progressPercent = (activeStepIndex / totalSteps) * 100;

        progressBar.style.width = `${progressPercent}%`;
        progressBar.setAttribute('aria-valuenow', progressPercent);
        progressBar.textContent = `Paso ${activeStepIndex} de ${totalSteps}`;
    }

    // Inicializar el primer paso como activo
    updateActiveStep(document.getElementById('step-1'));
</script>
@stop
