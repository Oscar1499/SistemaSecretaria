@extends('adminlte::page')

@section('title', 'Agregar Libro')

@section('content_header')
<h1>Agregar Libro</h1>
@stop

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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
                    Paso 1 de 3
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
                    <div class="step" data-target="#step-2">
                        <button type="button" class="step-trigger" role="tab" id="stepper-step-2" aria-controls="step-2">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">Representación del consejo</span>
                        </button>
                    </div>
                    <div class="line"></div>

                    <!-- Paso 3 -->
                    <div class="step" data-target="#step-3">
                        <button type="button" class="step-trigger" role="tab" id="stepper-step-3" aria-controls="step-3">
                            <span class="bs-stepper-circle">3</span>
                            <span class="bs-stepper-label">Apertura del libro</span>
                        </button>
                    </div>
                </div>

                <div class="bs-stepper-content">
                    <!-- Formulario con pasos -->
                    <form action="{{ route('acuerdos.store') }}" method="POST">
                        @csrf

                        <!-- Paso 1: Seleccionar Acta -->
                        <div id="step-1" class="content active tab-pane" role="tabpanel" aria-labelledby="stepper-step-1">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="fecha">Fecha de ingreso</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="fecha" name="fecha" value="{{ old('fecha', now()->toDateString()) }}" required />
                                        <span class="input-group-text">
                                            <i class="bi bi-calendar-plus"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fecha2">Fecha de fin</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="fecha2" name="fecha2" value="{{ old('fecha2', now()->toDateString()) }}" required />
                                        <span class="input-group-text">
                                            <i class="bi bi-calendar-plus"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group position-relative">
                                    <label for="descripcion_Acuerdos">Descripción del libro</label>
                                    <textarea
                                        class="form-control input-with-icon"
                                        id="descripcion_Acuerdos"
                                        name="descripcion_Acuerdos"
                                        placeholder="Escriba una descripción detallada del libro"
                                        rows="5"
                                        required></textarea>
                                </div>

                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-primary next-step">Siguiente <i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>

                        <!-- Paso 2: Redactar el Memorando -->
                        <div id="step-2" class="content" role="tabpanel" aria-labelledby="stepper-step-2">

                            <div class="mt-3">
                                <button type="button" class="btn btn-secondary previous-step"><i class="bi bi-arrow-left"></i> Anterior</button>
                                <button type="button" class="btn btn-primary next-step">Siguiente <i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>

                        <!-- Paso 3: Seleccionar Personal -->
                        <div id="step-3" class="content" role="tabpanel" aria-labelledby="stepper-step-3">
                            <div class="form-group">
                                <label for="id_Personal">Personal</label>
                                <select id="id_Personal" name="id_Personal" class="form-control select2" required>
                                    <option value="" disabled selected>Seleccione el Personal</option>
                                </select>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-secondary previous-step"><i class="bi bi-arrow-left"></i> Anterior</button>
                                <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Guardar Libro</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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

        // Aseguramos que siempre haya 3 pasos
        const totalSteps = 3;
        const progressPercent = (activeStepIndex / totalSteps) * 100;

        progressBar.style.width = `${progressPercent}%`;
        progressBar.setAttribute('aria-valuenow', progressPercent);
        progressBar.textContent = `Paso ${activeStepIndex} de ${totalSteps}`;
    }

    // Inicializar el primer paso como activo
    updateActiveStep(document.getElementById('step-1'));
</script>


<!-- Alerta de éxito de guardado-->
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: "El libro se ha agregado correctamente.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 3000,
        toast: true,
        position: 'top-end'
    });
</script>
@endif

<!-- Alerta de error de al agregar -->
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: "Hubo un problema al agregar el libro. Inténtalo de nuevo.",
        confirmButtonText: 'Aceptar',
        showConfirmButton: true,
        timer: 5000,
        toast: true,
        position: 'top-end'
    });
</script>
@endif
@stop