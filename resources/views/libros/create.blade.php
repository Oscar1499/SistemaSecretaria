@extends('adminlte::page')

@section('title', 'Agregar Libro')

@section('content_header')
<h1><i class="bi bi-book-fill me-2"></i> Apertura de Libro</h1>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
@stop

@section('content')
<?php
function numToText($number)
{
    $formatter = new NumberFormatter('es', NumberFormatter::SPELLOUT);
    return $formatter->format($number);
}

$formatter = new NumberFormatter('es_SV', NumberFormatter::SPELLOUT);

$anio = date('Y');
$hora = date('H');
$minutos = date('i');
$dia = date('d');
$mes = date('n'); // Obtener el número del mes
// Convertir el año a texto a texto en español
$horaEnTexto = $formatter->format($hora);
$minutosEnTexto = $formatter->format($minutos);
$anioEnTexto = $formatter->format($anio);

// Convertir el mes a texto en español
$mesEnTexto = [
    1 => 'enero',
    2 => 'febrero',
    3 => 'marzo',
    4 => 'abril',
    5 => 'mayo',
    6 => 'junio',
    7 => 'julio',
    8 => 'agosto',
    9 => 'septiembre',
    10 => 'octubre',
    11 => 'noviembre',
    12 => 'diciembre',
][$mes];

?>

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
                    Paso 1 de 3
                </div>
            </div>
            <input type="hidden" id="Mes" name="Mes" />
            <script>
                var mesxd = document.getElementById("Mes").value;
            </script>
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
                    <form action="{{ route('libros.store') }}" method="POST">
                        @csrf

                        <!-- Paso 1: Configuración del libro-->
                        <div id="step-1" class="content active tab-pane" role="tabpanel" aria-labelledby="stepper-step-1">

                            <div class="form-group">
                                <div class="form-group">
                                    <label for="fecha">
                                        <i class="bi bi-calendar-event me-2"></i>
                                        Fecha de ingreso
                                    </label>

                                    <div class="input-group">
                                        <input oninput="actualizarMesYTexto(); " type="date" class="form-control" id="fecha" name="fechainicio_Libro" value="{{ old('fecha', now()->toDateString()) }}" required />
                                        <span class="input-group-text">
                                            <i class="bi bi-calendar-plus"></i>
                                        </span>
                                    </div>
                                </div>

                                <!-- Aquí se mostrará el mes -->
                                <input type="hidden" id="mesSeleccionado" name="mesSeleccionado" />
                                <div class="form-group">

                                    <label for="fecha2">
                                        <i class="bi bi-calendar-x me-2"></i>
                                        Fecha de fin
                                    </label>

                                    <div class="input-group">
                                        <input type="date" class="form-control" id="fecha2" name="fechafinal_Libro" value="{{ old('fecha2', now()->toDateString()) }}" required />
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

                                    <textarea
                                        class="form-control input-with-icon"
                                        id="descripcion_Acuerdos"
                                        name="descripcion_Libro"
                                        placeholder="Escriba una descripción detallada del libro"
                                        rows="5"
                                        required></textarea>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="button" class="btn btn-primary next-step" disabled>Siguiente <i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>

                        <!-- Paso 2: Representación del consejo -->
                        <div id="step-2" class="content" role="tabpanel" aria-labelledby="stepper-step-2">
                            <div class="form-group">

                                <label for="alcalde">
                                    <i class="bi bi-person-badge me-2"></i>
                                    Seleccione Alcalde
                                </label>
                                <div class="input-group">
                                    <select class="form-select form-select-sm" id="alcalde" name="alcalde">
                                        <option selected>Seleccione</option>
                                        @foreach($alcalde as $alcaldes)
                                        <option data-alcalde="{{$alcaldes->id}}" value="{{$alcaldes->id}}">{{$alcaldes->nombre}} {{$alcaldes->apellido}} ({{$alcaldes->cargo}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">

                                <label for="sindico">
                                    <i class="bi bi-person-badge me-2"></i>
                                    Seleccione Sindico
                                </label>

                                <div class="input-group">
                                    <select class="form-select form-select-sm" id="sindico" name="sindico">
                                        <option selected>Seleccione</option>
                                        @foreach($sindico as $sindicos)
                                        <option value="{{$sindicos->id}}">{{$sindicos->nombre}} {{$sindicos->apellido}} ({{$sindicos->cargo}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-secondary previous-step"><i class="bi bi-arrow-left"></i> Anterior</button>
                                <button type="button" class="btn btn-primary next-step" disabled>Siguiente <i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>

                        {{-- Paso 3: Apertura del libro --}}
                        <div id="step-3" class="content" role="tabpanel" aria-labelledby="stepper-step-3">

                            <div class="form-group">
                                <label for="notas"><i class="bi bi-pencil-fill me-2"></i> Apertura del libro</label>
                                <textarea class="form-control" id="notas" name="apertura_Libro" required></textarea>
                            </div>

                            @section('css')
                            <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
                            @endsection

                            <!-- Botones de navegación -->
                            <div class="mt-3">
                                <?php $diaSeleccionado = old('diaSeleccionado') ?? '';?>
                                <input type="hidden" id="diaSeleccionado" name="diaSeleccionado" value="{{ $diaSeleccionado }}">
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
</body>

</html>
@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<!-- Incluir la librería num2words desde el CDN -->
<script src="https://cdn.jsdelivr.net/npm/num2words@1.0.1/num2words.min.js"></script>

<script>
    // Función para extraer el día y el mes del input de fecha
    function obtenerFecha() {
        const fecha = document.getElementById("fecha").value;
        if (!fecha) return null;

        // Crear el objeto Date usando valores locales
        const [year, month, day] = fecha.split('-');
        const fechaObj = new Date(year, month - 1, day);

        const meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        const nombreDelMes = meses[fechaObj.getMonth()];
        const dia = fechaObj.getDate();

        return {
            dia,
            mes: nombreDelMes
        };
    }

    function numeroAPalabras(numero) {
        const numerosEnPalabras = [
            '', 'Uno', 'Dos', 'Tres', 'Cuatro', 'Cinco', 'Seis', 'Siete', 'Ocho', 'Nueve', 'Diez',
            'Once', 'Doce', 'Trece', 'Catorce', 'Quince', 'Dieciséis', 'Diecisiete', 'Dieciocho', 'Diecinueve', 'Veinte',
            'Veintiuno', 'Veintidós', 'Veintitrés', 'Veinticuatro', 'Veinticinco', 'Veintiséis', 'Veintisiete', 'Veintiocho', 'Veintinueve', 'Treinta', 'Treinta y uno'
        ];
        return numerosEnPalabras[numero] || 'el día';
    }

    // Función para actualizar el texto en Summernote
    function actualizarTexto() {
        const fecha = obtenerFecha();
        const diaSeleccionado = numeroAPalabras(fecha?.dia) || 'el día';
        const mesSeleccionadoVariable = fecha?.mes || 'el mes';

        const alcaldeSeleccionado = $('#alcalde option:selected').text() || 'Nombre del Alcalde';
        const sindicoSeleccionado = $('#sindico option:selected').text() || 'Nombre del Síndico';

        // Generar el texto dinámico
        const textoInicial = `
            <p style="text-align: justify;"><strong>ALCALDÍA MUNICIPAL DE LA UNIÓN SUR, DEPARTAMENTO DE LA UNIÓN,</strong>
            a las <?php echo $horaEnTexto ?> horas y <?php echo $minutosEnTexto ?> minutos del día ${diaSeleccionado} de ${mesSeleccionadoVariable} del año <?php echo $anioEnTexto ?>, EL PRIMER CONSEJO MUNICIPAL PLURAL,
            juramentado constitucionalmente para el periodo 2024-2027, AUTORIZA Y HABILITA el presente Libro de Actas de Sesiones,
            debidamente foliado y sellado para que en él se asienten las actas de sesiones que celebre el primer Concejo Municipal Plural de
            La Unión Sur, del departamento de La Unión, durante el periodo de ${mesSeleccionadoVariable} a diciembre del año <?php echo $anioEnTexto ?>.</p>

            <p style="text-align: center;"><strong>______________________</strong></p>
            <p style="text-align: center;"><strong>${alcaldeSeleccionado}</strong></p>

            <p style="text-align: center;"><strong>______________________</strong></p>
            <p style="text-align: center;"><strong>${sindicoSeleccionado}</strong></p>
        `;

        // Insertar el texto generado en Summernote
        $('#notas').summernote('code', textoInicial);
    }

    // Función principal: obtiene el mes y actualiza Summernote
    function actualizarMesYTexto() {
        actualizarTexto();
    }

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

        // Eventos para actualizar dinámicamente
        $('#fecha').on('change', actualizarMesYTexto);
        $('#alcalde, #sindico').on('change', actualizarTexto);

        // Actualizar el contenido de Summernote al cargar la página
        actualizarMesYTexto();
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


<script>
    // Función para validar los campos de selección en el Paso 2
    function validar_Step2() {
        const selectAlcalde = document.querySelector('select[name="alcalde"]');
        const selectSindico = document.querySelector('select[name="sindico"]');
        const nextStepButton = document.querySelector('#step-2 .next-step');

        // Verificar si las opciones seleccionadas son válidas
        if (
            selectAlcalde.value !== "Seleccione" &&
            selectAlcalde.value.trim() !== "" &&
            selectSindico.value !== "Seleccione" &&
            selectSindico.value.trim() !== ""
        ) {
            nextStepButton.disabled = false;
        } else {
            nextStepButton.disabled = true;
        }
    }

    // Deshabilitar botón al cargar la página y añadir eventos
    document.addEventListener('DOMContentLoaded', () => {
        const nextStepButton = document.querySelector('#step-2 .next-step');
        nextStepButton.disabled = true;

        // Asociar la validación al cambio de selección en los select
        const selectAlcalde = document.querySelector('select[name="alcalde"]');
        const selectSindico = document.querySelector('select[name="sindico"]');

        selectAlcalde.addEventListener('change', validar_Step2);
        selectSindico.addEventListener('change', validar_Step2);
    });
    // Función para validar los campos en el Paso 1
    function validar_Step1() {
        const fechaIngreso = document.getElementById('fecha').value.trim();
        const fechaFin = document.getElementById('fecha2').value.trim();
        const descripcionLibro = document.getElementById('descripcion_Acuerdos').value.trim();
        const nextStepButton = document.querySelector('#step-1 .next-step');

        // Verificar si los campos están llenos
        if (fechaIngreso !== "" && fechaFin !== "" && descripcionLibro !== "") {
            nextStepButton.disabled = false;
        } else {
            nextStepButton.disabled = true;
        }
    }

    // Deshabilitar botón al cargar la página y añadir eventos
    document.addEventListener('DOMContentLoaded', () => {
        const nextStepButton = document.querySelector('#step-1 .next-step');
        nextStepButton.disabled = true;

        // Asociar la validación al cambio de los campos
        document.getElementById('fecha').addEventListener('input', validar_Step1);
        document.getElementById('fecha2').addEventListener('input', validar_Step1);
        document.getElementById('descripcion_Acuerdos').addEventListener('input', validar_Step1);
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

@stop