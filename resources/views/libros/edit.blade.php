@extends('adminlte::page')

@section('title', 'Editar Libro')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="bi bi-book-fill me-2"></i>Editar Libro</h1>
    <a href="{{ route('libros.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle me-1"></i> Regresar
    </a>
</div>
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
    1 => 'enero', 2 => 'febrero', 3 => 'marzo',
    4 => 'abril', 5 => 'mayo', 6 => 'junio',
    7 => 'julio', 8 => 'agosto', 9 => 'septiembre',
    10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre',
][$mes];

$texto = $libro->apertura_Libro;

function extraerTexto($patron, $texto, $default) {
    preg_match($patron, $texto, $coincidencias);
    return !empty($coincidencias[1]) ? $coincidencias[1] : $default;
}

$minutosFiltrados = extraerTexto('/y (.*?) minutos/', $texto, 'No se encontró texto válido.');
$HoraFiltrado = extraerTexto('/las (.*?) horas/', $texto, 'No se encontró texto válido.');
$alcaldeSeleccionado = extraerTexto('/<p[^>]*id="alcaldeSeleccionado"[^>]*>.*?<strong>(.*?)<\/strong>/s', $texto, 'Nombre del Alcalde');
$sindicoSeleccionado = extraerTexto('/<p[^>]*id="sindicoSeleccionado"[^>]*>.*?<strong>(.*?)<\/strong>/s', $texto, 'Nombre del Síndico');
$sindico1 = extraerTexto('/<p[^>]*id="sindico"[^>]*>.*?<strong>(.*?)<\/strong>/s', $texto, 'Síndico Municipal');
$alcalde1 = extraerTexto('/<p[^>]*id="alcalde"[^>]*>.*?<strong>(.*?)<\/strong>/s', $texto, 'Alcalde Municipal');
?>

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
<div class="card container-fluid p-0">
    <div class="card-body">
        <!-- Barra de Progreso -->
        <div class="progress mb-0">
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
                                    <input oninput="actualizarMesYTexto(); " type="date" class="form-control" id="fecha" name="fechainicio_Libro" value="{{$libro->fechainicio_Libro}}" required />
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
                                    <input type="date" class="form-control" id="fecha2" name="fechafinal_Libro" value="{{$libro->fechafinal_Libro}}" required />
                                    <span class="input-group-text">
                                        <i class="bi bi-calendar-plus"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group position-relative">

                                <label for="descripcion_Libro">
                                    <i class="bi bi-file-text me-2"></i>
                                    Descripción del libro
                                </label>

                                <textarea
                                    class="form-control input-with-icon"
                                    id="descripcion_Libro"
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
                                    <option data-alcalde="{{$alcaldes->id}}" value="{{$alcaldes->id}}">{{$alcaldes->nombre}} {{$alcaldes->apellido}}</option>
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
                                    <option value="{{$sindicos->id}}">{{$sindicos->nombre}} {{$sindicos->apellido}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary previous-step"><i class="bi bi-arrow-left"></i> Anterior</button>
                            <button type="button" class="btn btn-primary next-step">Siguiente <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>

                    {{-- Paso 3: Apertura del libro --}}
                    <div id="step-3" class="content" role="tabpanel" aria-labelledby="stepper-step-3">
                        <!-- Formulario para la apertura del libro -->
                        <div class="form-group">
                            <label for="notas" class="form-label">
                                <i class="bi bi-pencil-fill me-1"></i> Apertura del libro
                            </label>

                            <!-- Selectores de hora y minutos -->
                            <div class="d-flex flex-wrap align-items-center mt-2">
                                <!-- Hora de Apertura -->
                                <div class="d-flex flex-column me-3">
                                    <label for="horaApertura" class="form-label mb-1">
                                        <i class="bi bi-clock-fill me-1"></i> Hora de Apertura
                                    </label>
                                    <select id="horaApertura" name="horaApertura" class="form-select">
                                        <option value="" disabled selected>Hora de apertura</option>
                                        <option value="">Cancelar la apertura manual</option>
                                        <!-- Opciones de 0 a 23 -->
                                        <script>
                                            for (let i = 0; i < 24; i++) {
                                                document.write(`<option value="${i}">${i.toString().padStart(1, '0')} Horas</option>`);
                                            }
                                        </script>
                                    </select>
                                </div>

                                <!-- Minutos de Apertura -->
                                <div class="d-flex flex-column">
                                    <label for="minutosApertura" class="form-label mb-1">
                                        <i class="bi bi-clock-fill me-1"></i> Minutos de Apertura
                                    </label>
                                    <select id="minutosApertura" name="minutosApertura" class="form-select">
                                        <option value="" disabled selected>Minutos de apertura</option>
                                        <option value="">Cancelar la apertura manual</option>
                                        <!-- Opciones de 0 a 59 -->
                                        <script>
                                            for (let i = 0; i < 60; i++) {
                                                document.write(`<option value="${i}">${i.toString().padStart(2, '0')} Minutos</option>`);
                                            }
                                        </script>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Área de texto para notas -->
                        <div>
                            <textarea class="form-control mt-2" id="notas" name="apertura_Libro" required></textarea>
                        </div>

                        @section('css')
                        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
                        @endsection

                        <!-- Botones de navegación -->
                        <div class="mt-3 d-flex justify-content-between">
                            <?php $diaSeleccionado = old('diaSeleccionado') ?? ''; ?>
                            <input type="hidden" id="diaSeleccionado" name="diaSeleccionado" value="{{ $diaSeleccionado }}">
                            <button type="button" class="btn btn-secondary previous-step">
                                <i class="bi bi-arrow-left"></i> Anterior
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-floppy"></i> Guardar Libro
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>
@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
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
            'cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez',
            'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve', 'veinte',
            'veintiuno', 'veintidós', 'veintitrés', 'veinticuatro', 'veinticinco', 'veintiséis', 'veintisiete', 'veintiocho', 'veintinueve', 'treinta', 'treinta y uno',
            'treinta y dos', 'treinta y tres', 'treinta y cuatro', 'treinta y cinco', 'treinta y seis', 'treinta y siete', 'treinta y ocho', 'treinta y nueve', 'cuarenta',
            'cuarenta y uno', 'cuarenta y dos', 'cuarenta y tres', 'cuarenta y cuatro', 'cuarenta y cinco', 'cuarenta y seis', 'cuarenta y siete', 'cuarenta y ocho', 'cuarenta y nueve', 'cincuenta',
            'cincuenta y uno', 'cincuenta y dos', 'cincuenta y tres', 'cincuenta y cuatro', 'cincuenta y cinco', 'cincuenta y seis', 'cincuenta y siete', 'cincuenta y ocho', 'cincuenta y nueve'
        ];
        return numerosEnPalabras[numero];
    }

    // Función para actualizar el texto en Summernote
    function actualizarTexto() {
        const fecha = obtenerFecha();
        const diaSeleccionado = numeroAPalabras(fecha?.dia) || 'el día';
        const mesSeleccionadoVariable = fecha?.mes || 'el mes';

        let alcaldeSeleccionado = $('#alcalde option:selected').text();
        let sindicoSeleccionado = $('#sindico option:selected').text();

        let hora_Seleccionada = $('#horaApertura').val();
        let minutos_Seleccionada = $('#minutosApertura').val();
        // Usar operador ternario para asignar valores
        alcaldeSeleccionado = alcaldeSeleccionado === "Seleccione" ? "<?php echo $alcaldeSeleccionado; ?>" : alcaldeSeleccionado;
        sindicoSeleccionado = sindicoSeleccionado === "Seleccione" ? "<?php echo $sindicoSeleccionado; ?>" : sindicoSeleccionado;

        minutos_Seleccionada = typeof minutos_Seleccionada === 'undefined' || minutos_Seleccionada === '' || minutos_Seleccionada === null ?
            "<?php echo $minutosFiltrados; ?>" :
            numeroAPalabras(minutos_Seleccionada);

        hora_Seleccionada = typeof hora_Seleccionada === 'undefined' || hora_Seleccionada === '' || hora_Seleccionada === null ?
            "<?php echo $HoraFiltrado; ?>" :
            numeroAPalabras(hora_Seleccionada);

        // Generar el texto dinámico
        const textoInicial = `
            <p style="text-align: justify;"><strong>ALCALDÍA MUNICIPAL DE LA UNIÓN SUR, DEPARTAMENTO DE LA UNIÓN,</strong>
            a las ${hora_Seleccionada} horas y ${minutos_Seleccionada} minutos del día ${diaSeleccionado} de ${mesSeleccionadoVariable} del año <?php echo $anioEnTexto ?>, EL PRIMER CONSEJO MUNICIPAL PLURAL,
            juramentado constitucionalmente para el periodo 2024-2027, AUTORIZA Y HABILITA el presente Libro de Actas de Sesiones,
            debidamente foliado y sellado para que en él se asienten las actas de sesiones que celebre el primer Concejo Municipal Plural de
            La Unión Sur, del departamento de La Unión, durante el periodo de ${mesSeleccionadoVariable} a diciembre del año <?php echo $anioEnTexto ?>.</p>


        <p style="display: none;" class="invisible-line"></p>
        <p style="display: none;" class="invisible-line"></p>
        <p style="text-align: center; line-height: 1.5; margin: 0;"><strong>______________________________________</strong></p>
        <p style="text-align: center; line-height: 1.5; margin: 0;" id="alcaldeSeleccionado"><strong>${alcaldeSeleccionado}</strong></p>
        <p style="text-align: center; line-height: 1.5; margin: 0;" id="alcalde"><strong><?php echo $alcalde1 ?></strong></p>
        <p style="display: none;" class="invisible-line"></p>
        <p style="display: none;" class="invisible-line"></p>
        <p style="text-align: center; line-height: 1.5; margin: 0;"><strong>______________________________________</strong></p>
        <p style="text-align: center; line-height: 1.5; margin: 0;" id="sindicoSeleccionado"><strong>${sindicoSeleccionado}</strong></p>
        <p style="text-align: center; line-height: 1.5; margin: 0;" id="sindico"><strong><?php echo $sindico1 ?></strong></p>
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
        $('#alcalde, #sindico, #horaApertura, #minutosApertura').on('change', actualizarTexto); // Agregar el evento aquí

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
        defaultDate: null,
        locale: {
            firstDayOfWeek: 1,
            weekdays: {
                shorthand: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']
            },
            months: {
                shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                longhand: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
            }
        }
    });

    flatpickr("#fecha2", {
        dateFormat: "Y-m-d",
        allowInput: true,
        defaultDate: new Date(new Date().getFullYear(), 11, 31),
        enable: [
        // Solo permitir fechas de diciembre
            function(date) {
                return date.getMonth() === 11;
            }
        ],
        onReady: function(selectedDates, dateStr, instance) {
            instance.jumpToDate(new Date(instance.currentYear, 11, 31));
            instance.calendarContainer.querySelectorAll(".flatpickr-monthDropdown-month, .flatpickr-prev-month, .flatpickr-next-month").forEach(el => {
                el.style.display = "none";
            });
        },
        locale: {
            firstDayOfWeek: 1,
            weekdays: {
                shorthand: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']
            },
            months: {
                shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                longhand: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
            }
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