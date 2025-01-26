@extends('adminlte::page')

@section('title', 'Crear Acta')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
<h1><i class="bi bi-file-earmark-text-fill me-2"></i>Crear Acta</h1>
    <a href="{{ route('actas.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle me-1"></i> Regresar
    </a>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
@stop

@section('content')
<?php
// Funcion para convertir el numero de Actas a texto
function numToText($number)
{
    $formatter = new NumberFormatter('es', NumberFormatter::SPELLOUT);
    return $formatter->format($number);
}
?>
<form action="{{ route('actas.store') }}" method="POST" id="actaForm">
    @csrf

    <!-- Campos ocultos para almacenar los contenidos dinámicos -->
    <input type="hidden" id="presentes" name="presentes" required />
    <input type="hidden" id="ausentes" name="ausentes" required />
    <input type="hidden" id="estado" name="estado" value="Abierto" />
    <input type="hidden" id="tipo_sesion" name="tipo_sesion" required />

    <!-- <input type="hidden" id="id_Personal" name="id_Personal" required /> -->


    <input type="hidden" id="alcaldesaInfo" value="{{ $alcaldesa ? $alcaldesa->nombre . ' ' . $alcaldesa->apellido . ' ' . $alcaldesa->cargo : 'No definida' }}">
    <input type="hidden" id="secretarioInfo" value="{{ $secretario ? $secretario->nombre . ' ' . $secretario->apellido .' '. $secretario->cargo : 'No definido' }}">

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
                    <span>Paso 1 de 4</span>
                </div>
            </div>
            <!-- Stepper -->
            <div class="bs-stepper">
                <div class="bs-stepper-header" role="tablist">
                    <!-- Paso 1 -->
                    <div class="step" data-target="#step-1">
                        <button type="button" class="step-trigger" role="tab" id="stepper-step-1" aria-controls="step-1">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label">Libro</span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <!-- Paso 2 -->
                    <div class="step" data-target="#step-2">
                        <button type="button" class="step-trigger" role="tab" id="stepper-step-2" aria-controls="step-2">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">Fecha</span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <!-- Paso 3 -->
                    <div class="step" data-target="#step-3">
                        <button type="button" class="step-trigger" role="tab" id="stepper-step-3" aria-controls="step-3">
                            <span class="bs-stepper-circle">3</span>
                            <span class="bs-stepper-label">Funcionarios Ausentes</span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <!-- Paso 4 -->
                    <div class="step" data-target="#step-4">
                        <button type="button" class="step-trigger" role="tab" id="stepper-step-4" aria-controls="step-4">
                            <span class="bs-stepper-circle">4</span>
                            <span class="bs-stepper-label">Acta</span>
                        </button>
                    </div>
                </div>
                <div class="bs-stepper-content">
                    <!-- Paso 1: Seleccionar Acta -->
                    <div id="step-1" class="content" role="tabpanel" aria-labelledby="stepper-step-1">
                        <div class="form-group">
                            <label for="id_libros"><i class="bi bi-book"></i> Libro</label>
                            <select class="form-control" id="id_libros" name="id_libros" required>
                                <option value="" selected>Seleccione un libro</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="descripcion"><i class="bi bi-info-circle"></i> Descripción de la sesión</label>
                            <textarea oninput="validartextarea();" class="form-control" name="descripcion" id="descripcion" placeholder="Escriba una descripción de la sesión (asistentes, temas, tratados, acuerdos, etc.)" rows="3" required></textarea>
                        </div>
                        <button type="button" class="btn btn-primary next-step" id="nextStepBtn1" disabled>Siguiente <i class="bi bi-arrow-right"></i></button>
                    </div>
                    <!-- Paso 2: Redactar el Memorando -->
                    <div id="step-2" class="content" role="tabpanel" aria-labelledby="stepper-step-2">
                        <div class="form-group">
                            <label for="fecha"><i class="bi bi-calendar-event me-2"></i> Fecha</label>
                            <input oninput="validarFecha(); actualizarTextoFecha();" type="date" class="form-control" id="fecha" name="fecha" value="{{ old('fecha', now()->toDateString()) }}" required>

                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary previous-step"><i class="bi bi-arrow-left"></i> Atrás</button>
                        <button type="button" class="btn btn-primary next-step" id="nextStepBtn" disabled>Siguiente <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                  
                    <!-- Paso 3: Seleccionar Personal -->
                    <div id="step-3" class="content" role="tabpanel" aria-labelledby="stepper-step-3">
                        <div class="form-group">
                            <label for="personal"><i class="bi bi-person-x-fill me-2"></i> Seleccionar Funcionarios Ausentes</label>
                            <div class="accordion" id="accordionPersonal">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapsePersonal" aria-expanded="false" aria-controls="collapsePersonal">
                                                Seleccionar Todos
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapsePersonal" class="collapse" aria-labelledby="headingOne" data-parent="#accordionPersonal">
                                        <div class="card-body">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" id="selectAll" onchange="toggleSelectAll()">
                                                    Todos Ausentes
                                                </label><br>
                                                @foreach ($personal as $persona)
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="personal[]" value="{{ $persona->id }}" onchange="updatePersonalAttendance(); Personal_xd();"><span id="icono-{{ $persona->id }}"></span>
                                                    {{ $persona->nombre }} {{ $persona->apellido }} {{ $persona->cargo }}
                                                    <small class="text-muted">({{ $persona->propietario ? 'Suplente' : 'Propietario' }}) <span id="icono-{{ $persona->id }}"></span></small>
                                                </label><br>
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary previous-step"><i class="bi bi-arrow-left"></i> Atrás</button>
                        <button type="button" class="btn btn-primary next-step">Siguiente <i class="bi bi-arrow-right"></i></button>
                    </div>
                    </div>
                    <!-- Paso 4: Acta -->
                    <div id="step-4" class="content" role="tabpanel" aria-labelledby="stepper-step-4">
                        <div class="form-group">
                            <label for="correlativo"><i class="bi bi-file-earmark-text me-2"></i> Número de Acta</label>
                            <input type="text" class="form-control font-weight-bold text-uppercase" id="correlativo" name="correlativo"
                                value="ACTA NÚMERO {{ mb_strtoupper(numToText($numero_Actas), 'UTF-8') }} DEL CONCEJO MUNICIPAL PLURAL DE LA UNIÓN SUR.-" readonly>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="Notas" name="contenido_elaboracion" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="motivo_ausencia"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i> Motivo de Ausencia</label>
                            <textarea
                                disabled
                                class="form-control"
                                id="motivo_ausencia"
                                name="motivo_ausencia"
                                placeholder="Escriba el motivo de ausencia para los que no se marcaron">Ninguno</textarea>
                            
                            <div class="mt-1 d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary previous-step mt-3">
                                <i class="bi bi-arrow-left"></i> Atrás
                            </button>
                            <button type="submit" class="btn btn-primary mt-3" onclick="submitForm()">
                                <i class="bi bi-floppy"></i> Guardar
                            </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Función para enviar el formulario -->
<script>
    function submitForm() {
        document.getElementById('actaForm').submit();
    }
</script>
@stop

@section('js')
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inicializar el stepper
        new Stepper(document.querySelector('.nav-pills'));

        // Inicializar Select2
        $('#id_libros').select2({
            width: '100%' // Asegura que ocupe el 100% del contenedor
        });

        const alcaldesaInfo = document.getElementById('alcaldesaInfo').value;
        const secretarioInfo = document.getElementById('secretarioInfo').value;
        let ausentes = [];
        let presentes = [];

        /**
         * Habilita o deshabilita el textarea de Motivo de Ausencia según haya o no funcionarios ausentes.
         * Se utiliza para evitar que se escriba un motivo de ausencia si no hay funcionarios ausentes.
         */
        function toggleMotivoAusenciaTextarea() {

            const motivoAusenciaTextarea = document.getElementById('motivo_ausencia');

            if (ausentes.length === 0) {
                motivoAusenciaTextarea.disabled = true;
            } else {
                motivoAusenciaTextarea.disabled = false;
            }
        }

        document.addEventListener("DOMContentLoaded", toggleMotivoAusenciaTextarea);
        document.querySelectorAll('.next-step, .previous-step, input, select, textarea').forEach(element => {
            element.addEventListener('change', toggleMotivoAusenciaTextarea);
        });

        // Función para manejar "Seleccionar Todos Ausentes"
        window.toggleSelectAll = function() {
            const isSelectAllChecked = document.getElementById('selectAll').checked;
            const checkboxes = document.querySelectorAll('input[name="personal[]"]');

            checkboxes.forEach(checkbox => {
                checkbox.checked = isSelectAllChecked;
            });

            // Resetear los arreglos de ausentes y presentes
            ausentes = [];
            presentes = [];

            // Si está seleccionado "Todos Ausentes", llenar el arreglo de ausentes
            if (isSelectAllChecked) {
                ausentes = @json($personal->map(function($persona) {
                    return $persona->nombre . ' ' . $persona->apellido . ' ' . $persona->cargo;
                }));
                presentes = []; // Asegurar que presentes esté vacío
            } else {
                // Si no está seleccionado, considerar a todos como presentes
                presentes = @json($personal->map(function($persona) {
                    return $persona->nombre . ' ' . $persona->apellido . ' ' . $persona->cargo;
                }));
                ausentes = []; // Asegurar que ausentes esté vacío
            }

            // Actualizar el contenido
            updatePersonalAttendance();
        };

        // Función para actualizar las listas de ausentes y presentes
        window.updatePersonalAttendance = function() {
            const checkboxes = document.querySelectorAll('input[name="personal[]"]');

            // Resetear los arreglos
            ausentes = [];
            presentes = [];

            // Clasificar los nombres según el estado del checkbox
            checkboxes.forEach(checkbox => {
                const label = checkbox.closest('label').innerText.trim();
                if (checkbox.checked) {
                    ausentes.push(label);
                } else {
                    presentes.push(label);
                }
            });

            // Actualizar el contenido
            actualizarTextoFecha();
        };

        function obtenerDia() {
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

        // Función para actualizar el contenido del texto en el Summernote
        function actualizarTextoFecha() {
            const fecha = obtenerDia();
            const diaSeleccionado = fecha?.dia || 'el día';
            const mesSeleccionadoVariable = fecha?.mes || 'el mes';

            let tipo_Sesion = (diaSeleccionado >= 1 && diaSeleccionado <= 5) || (diaSeleccionado >= 10 && diaSeleccionado <= 15) ? 'Ordinaria' : 'Extraordinaria';
            document.getElementById('tipo_sesion').value = tipo_Sesion;

            // Si no hay personal seleccionado, considerar a todos como presentes
            if (presentes.length === 0 && ausentes.length === 0) {
                presentes = @json($personal->map(function($persona) {
                    return $persona->nombre . ' ' . $persona->apellido . ' ' . $persona->cargo;
                }));
                ausentes = [];
            }

            const ausentesTexto = ausentes.length > 0 ? ausentes.join(', ') : 'Ninguno';
            const presentesTexto = presentes.length > 0 ? presentes.join(', ') : 'Ninguno';

            // Actualizar campos ocultos antes de enviar el formulario
            document.getElementById('ausentes').value = ausentesTexto;
            document.getElementById('presentes').value = presentesTexto;

            const fechaTexto = `
        <p style="text-align: justify;">En las instalaciones del Centro Municipal para la Prevención de la Violencia, del distrito de la Unión,
        Municipio de La Unión Sur, departamento de La Unión, a las <span id="horaTexto">${new Date().getHours()}</span> horas del día
        <span id="diaTexto">${diaSeleccionado}</span> de <span id="mesTexto">${mesSeleccionadoVariable}</span> del
        <span id="anoTexto">${new Date().getFullYear()}</span>.
        En avenencia de artículo 31 numeral 10, artículo 38, artículo 48, numeral 1 del Código
        Municipal, en sesión ${tipo_Sesion}, convocada y presidida por
        <strong>${alcaldesaInfo} Municipal de La Unión Sur</strong>, con el infrascrito Secretario Municipal,
        <strong>${secretarioInfo}</strong>;
        presentes los miembros del Concejo Municipal Plural de La Unión: <a id="presentPersonal">${presentesTexto}</a>
        <strong>y Ausencia de: <span id="FaltaPersonal">${ausentesTexto}</span>.</strong></p>
    `;

            // Insertar el texto generado en Summernote
            $('#Notas').summernote('code', fechaTexto);
        }

        // Inicialización de Summernote y eventos
        $(document).ready(function() {
            // Inicializar Summernote
            $('#Notas').summernote({
                height: 400,
                lang: 'es-SV',
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

            // Enlazar evento al cambio del campo de fecha
            document.getElementById('fecha').addEventListener('change', actualizarTextoFecha);

            // Actualizar contenido inicial
            actualizarTextoFecha();
        });

        // Inicializar Flatpickr para el campo de fecha
        flatpickr("#fecha", {
            dateFormat: "Y-m-d",
            allowInput: true,
            position: "auto",
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

        // Función para manejar cambios individuales en los checkboxes
        window.handleCheckboxChange = function() {
            document.getElementById('selectAll').checked = false;
            updatePersonalAttendance();
        };

        window.updateMotivoAusencia = function() {
            const FaltaPersonal = document.getElementById('FaltaPersonal');
            const motivoAusencia = $('#motivo_ausencia').summernote('code');

            // Asignar el contenido enriquecido a FaltaPersonal
            if (motivoAusencia.trim() !== '') {
                FaltaPersonal.innerHTML = motivoAusencia;
            } else {
                FaltaPersonal.innerText = 'Ninguno';
            }
        }

        document.querySelectorAll('input[name="personal[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', handleCheckboxChange);
        });
    });

    function validarFecha() {
                            const fechaInput = document.getElementById("fecha");

                            const nextStepButton = document.getElementById("nextStepBtn");

                            if (fechaInput.value.trim() !== "") {
                                nextStepButton.disabled = false;
                            } else {
                                nextStepButton.disabled = true;
                            }
                        }

                        function validartextarea() {
                            const textarea = document.getElementById("descripcion");
                            const nextStepButton = document.getElementById("nextStepBtn1");

                            if (textarea.value.trim() !== "") {
                                nextStepButton.disabled = false;
                            } else {
                                nextStepButton.disabled = true;
                            }
                        }
</script>

<!-- Funcion para mostrar los iconos de Funcionarios presentes y ausentes -->
<script>
    const checkboxes = document.querySelectorAll('input[name="personal[]"]');
    const selectAll = document.getElementById('selectAll');

    function updateIcons() {
        checkboxes.forEach(checkbox => {
            const iconSpan = document.getElementById('icono-' + checkbox.value);
            if (checkbox.checked) {
                iconSpan.innerHTML = '<i class="bi bi-person-dash-fill text-danger"></i>'; // Representa empleados ausentes
            } else {
                iconSpan.innerHTML = '<i class="bi bi-person-check-fill text-success"></i>'; // Representa empleados presentes
            }
        });
    }

    // Ejecutar una vez al cargar la página para mostrar los iconos
    updateIcons();

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateIcons);
    });

    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
        updateIcons();
    });
</script>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

    /* Estilos para los checkboxes y etiquetas */
    #toggleCheckboxes {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 16px;
        cursor: pointer;
        text-align: center;
        font-size: 1rem;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    #toggleCheckboxes:hover {
        background-color: #0056b3;
    }

    #checkboxContainer {
        margin-top: 10px;
        padding-left: 20px;
        border-left: 2px solid #ccc;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .form-check-input {
        margin-right: 25px !important;
        width: 16px;
        height: 16px;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .form-check-input:hover {
        transform: scale(1.1);
    }

    .small.text-muted {
        font-size: 0.875rem;
        color: #6c757d;
        margin-left: 8px;
    }

    .form-check-label {
        font-size: 1rem;
        color: #555;
        margin-bottom: 5px;
        display: block;
        margin-left: 25px;
        cursor: pointer;
    }
</style>
@stop