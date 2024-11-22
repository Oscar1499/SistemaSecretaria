@extends('adminlte::page')

@section('title', 'Crear Acta')

@section('content_header')
    <h1>Crear Acta</h1>
@stop

@section('content')
    <form id="form-acta" action="{{ route('actas.store') }}" method="POST">
        @csrf

        <!-- Campos ocultos para almacenar los contenidos dinámicos -->
        <input type="hidden" id="contenido_elaboracion" name="contenido_elaboracion">
        <input type="hidden" id="presentes" name="presentes">
        <input type="hidden" id="ausentes" name="ausentes">
        <input type="hidden" id="tipo_sesion" name="tipo_sesion">

        <div class="steps">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="#step-1" data-toggle="pill">Libro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-2" data-toggle="pill">Fecha</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-3" data-toggle="pill">Funcionarios Ausentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-4" data-toggle="pill">Acta</a>
                </li>
            </ul>
        </div>

        <div class="tab-content">
            <!-- Paso 1: Libro -->
            <div class="tab-pane active" id="step-1">
                <div class="form-group">
                    <label for="id_libros">Libro</label>
           <!-- Remove the 'required' attribute here -->
<select class="form-control" id="id_libros" name="id_libros">
    @foreach ($libros as $libro)
        <option value="{{ $libro->id }}" {{ $libro->id == $libroActual->id ? 'selected' : '' }}>
            {{ $libro->nombre }} ({{ $libro->anio }})
        </option>
    @endforeach
</select>

                </div>
                <button type="button" class="btn btn-secondary previous-step">Atrás</button>
                <button type="button" class="btn btn-primary next-step">Siguiente</button>
            </div>

            <!-- Paso 2: Fecha -->
            <div class="tab-pane" id="step-2">
                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ old('fecha', now()->toDateString()) }}" required>
                </div>
                <button type="button" class="btn btn-secondary previous-step">Atrás</button>
                <button type="button" class="btn btn-primary next-step">Siguiente</button>
            </div>

            <!-- Paso 3: Funcionarios Ausentes -->
            <div class="tab-pane" id="step-3">
                <div class="form-group">
                    <label for="personal">Seleccionar Funcionarios Ausentes</label>
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
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" id="selectAllPresentes" onchange="toggleSelectAll()">
                                            Todos Presentes
                                        </label><br>

                                        @foreach ($personal as $persona)
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="personal[]" value="{{ $persona->id }}" onchange="updatePersonalAttendance()" required>
                                                {{ $persona->nombre }} {{ $persona->apellido }} {{ $persona->cargo }}
                                                <small class="text-muted">({{ $persona->propietario ? 'Suplente' : 'Propietario' }})</small>
                                            </label><br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary previous-step">Atrás</button>
                <button type="button" class="btn btn-primary next-step">Siguiente</button>
            </div>

            <!-- Paso 4: Acta -->
            <div class="tab-pane" id="step-4">
                <div class="form-group">
                    <label for="correlativo">Número de Acta</label>
                    <input type="text" class="form-control font-weight-bold text-uppercase" id="correlativo" name="correlativo"
                           value="ACTA NÚMERO {{ $correlativo ?? '1' }} DEL CONCEJO MUNICIPAL PLURAL DE LA UNIÓN SUR.-" readonly>
                </div>

                <p id="fechaTexto">
                    En las instalaciones del Centro Municipal para la Prevención de la Violencia, del distrito de la Unión,
                    Municipio de La Unión Sur, departamento de La Unión, a las <span id="horaTexto">{{ now()->translatedFormat('H') }}</span> horas del día
                    <span id="diaTexto">{{ now()->format('j') }}</span> de <span id="mesTexto">{{ \Carbon\Carbon::now()->locale('es')->translatedFormat('F') }}</span> del
                    <span id="anoTexto">{{ now()->year }}</span>.
                    En avenencia de artículo 31 numeral 10, artículo 38, artículo 48, numeral 1 del Código
                    Municipal, en sesión <strong><span id="tipoSesion"></span></strong>, convocada y presidida por
                    <strong>{{ $alcaldesa ? $alcaldesa->nombre . ' ' . $alcaldesa->apellido . ' ' . $alcaldesa->cargo : 'No definida' }}
                    Municipal de La Unión Sur</strong>, con el infrascrito Secretario Municipal,
                    <strong>{{ $secretario ? $secretario->nombre . ' ' . $secretario->apellido : 'No definida' }}</strong>;
                    presentes los miembros del Concejo Municipal Plural de La Unión: <a id="presentPersonal"></a>
                    <strong>y Ausencia de:  <span id="FaltaPersonal">Ninguno</span>.</strong>
                </p>

                <div class="form-group">
                    <label for="motivo_ausencia">Motivo de Ausencia</label>
                    <textarea class="form-control" id="motivo_ausencia" name="motivo_ausencia" placeholder="Escriba el motivo de ausencia para los que no se marcaron" oninput="updateMotivoAusencia()" required></textarea>
                </div>

                <div class="form-group text-center">
                   <button type="button" class="btn btn-secondary previous-step">Atrás</button>
                    <button type="submit" class="btn btn-primary" >Guardar</button>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmación -->

    </form>
@stop

@section('js')

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

    // Inicializar Summernote
    $('#motivo_ausencia').summernote({
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

    // Inicializar Flatpickr para el campo de fecha
    flatpickr("#fecha", {
        dateFormat: "Y-m-d",
        allowInput: true,
        position: "auto",
    });

    // Función para ajustar y actualizar la fecha y tipo de sesión
    function ajustarFecha(fechaSeleccionada) {
        const dia = fechaSeleccionada.getDate();
        const mes = fechaSeleccionada.toLocaleString('es-ES', { month: 'long' });
        const ano = fechaSeleccionada.getFullYear();

        document.getElementById('diaTexto').innerText = dia;
        document.getElementById('mesTexto').innerText = mes;
        document.getElementById('anoTexto').innerText = ano;
    }

    function actualizarTipoSesion(fechaSeleccionada) {
        const dia = fechaSeleccionada.getDate();
        const tipoSesion = (dia >= 1 && dia <= 5) || (dia >= 15 && dia <= 20) ? 'Ordinaria' : 'Extraordinaria';
        document.getElementById('tipoSesion').innerText = tipoSesion;
    }

    // Ajustar la fecha y tipo de sesión al cargar la página
    const fechaInput = document.getElementById("fecha");
    const fechaHoy = new Date(fechaInput.value + 'T00:00:00'); // Asegura que la fecha sea correcta
    ajustarFecha(fechaHoy);
    actualizarTipoSesion(fechaHoy);

    // Actualizar la fecha y tipo de sesión al cambiar la fecha
    fechaInput.addEventListener("change", function() {
        const fechaSeleccionada = new Date(fechaInput.value + 'T00:00:00');
        ajustarFecha(fechaSeleccionada);
        actualizarTipoSesion(fechaSeleccionada);
    });

    // Función para actualizar los campos ocultos antes de enviar el formulario
    function actualizarCamposOcultos() {
        // Obtener el contenido de 'contenido_elaboracion' como HTML
        const contenidoElaboracion = document.getElementById('fechaTexto').outerHTML +
                                     document.getElementById('tipoSesion').outerHTML +
                                     document.getElementById('presentPersonal').outerHTML +
                                     document.getElementById('FaltaPersonal').outerHTML;

        // Obtener los nombres de presentes y ausentes
        const presentes = document.getElementById('presentPersonal').innerText || 'Ninguno';
        const ausentes = document.getElementById('FaltaPersonal').innerText || 'Ninguno';
        const tipoSesion = document.getElementById('tipoSesion').innerText || 'No definido';

        // Asignar los valores a los campos ocultos
        document.getElementById('contenido_elaboracion').value = contenidoElaboracion;
        document.getElementById('presentes').value = presentes;
        document.getElementById('ausentes').value = ausentes;
        document.getElementById('tipo_sesion').value = tipoSesion;
    }

    // Actualizar campos ocultos al cambiar cualquier dato relevante
    document.querySelectorAll('.next-step, .previous-step, input, select, textarea').forEach(element => {
        element.addEventListener('change', actualizarCamposOcultos);
    });

    // Actualizar campos ocultos antes de enviar el formulario
    document.getElementById('form-acta').addEventListener('submit', function(e) {
        actualizarCamposOcultos();
        // Eliminar la línea que previene la sumisión del formulario
        // e.preventDefault();
        // console.log("Datos del formulario:", new FormData(this));
    });

    // Funciones existentes para gestionar los checkboxes
    window.updatePersonalAttendance = function() {
        const checkboxes = document.querySelectorAll('input[name="personal[]"]');
        const presentPersonal = document.getElementById('presentPersonal');
        const FaltaPersonal = document.getElementById('FaltaPersonal');

        const selectedNames = [];
        const presentNames = [];

        checkboxes.forEach(checkbox => {
            const label = checkbox.closest('label').innerText.trim();

            if (checkbox.checked) {
                presentNames.push(label);
            } else {
                selectedNames.push(label);
            }
        });

        FaltaPersonal.innerText = selectedNames.length > 0 ? selectedNames.join(', ') : 'Ninguno';
        presentPersonal.innerText = presentNames.length > 0 ? presentNames.join(', ') : 'Ninguno';

        // Actualizar los campos ocultos después de cambiar la asistencia
        actualizarCamposOcultos();
    }

    window.toggleSelectAll = function() {
        var isSelectAllChecked = document.getElementById('selectAll').checked;
        var checkboxes = document.querySelectorAll('input[name="personal[]"]');
        var isAllPresentesChecked = document.getElementById('selectAllPresentes').checked;

        if (isAllPresentesChecked) {
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = true;
                checkbox.disabled = true;
            });
            document.getElementById('selectAll').checked = false;
            updatePersonalAttendance();
            return;
        }

        checkboxes.forEach(function(checkbox) {
            checkbox.disabled = false;
            checkbox.checked = isSelectAllChecked;
        });

        updatePersonalAttendance();
    }

    window.updateMotivoAusencia = function() {
        const FaltaPersonal = document.getElementById('FaltaPersonal');
        const motivoAusencia = $('#motivo_ausencia').summernote('code');

        // Asignar el contenido enriquecido a FaltaPersonal
        if (motivoAusencia.trim() !== '') {
            FaltaPersonal.innerHTML = motivoAusencia;
        } else {
            FaltaPersonal.innerText = 'Ninguno';
        }

        // Actualizar los campos ocultos
        actualizarCamposOcultos();
    }

    // Validar y habilitar/deshabilitar el campo de motivo de ausencia
    function validateMotivoAusencia() {
        const checkboxesAusentes = document.querySelectorAll('input[name="personal[]"]:checked');
        const motivoAusenciaField = $('#motivo_ausencia');

        if (checkboxesAusentes.length === 0) {
            motivoAusenciaField.summernote('disable');
            motivoAusenciaField.summernote('code', '');
        } else {
            motivoAusenciaField.summernote('enable');
        }
    }

    document.querySelectorAll('input[name="personal[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', validateMotivoAusencia);
    });

    document.getElementById('selectAll').addEventListener('change', validateMotivoAusencia);
    document.getElementById('selectAllPresentes').addEventListener('change', validateMotivoAusencia);
    validateMotivoAusencia();
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Validación y navegación entre pasos
        document.querySelectorAll(".next-step").forEach(button => {
            button.addEventListener("click", function() {
                const activeTab = document.querySelector(".tab-pane.active");
                const inputs = activeTab.querySelectorAll("input, select, textarea");
                let valid = true;

                inputs.forEach(input => {
                    if (input.hasAttribute("required") && !input.value) {
                        valid = false;
                        input.classList.add("is-invalid");
                    } else {
                        input.classList.remove("is-invalid");
                    }
                });

                if (valid) {
                    // Navegar al siguiente paso
                    const nextTab = document.querySelector(`.nav-link[href="#${activeTab.id}"]`).parentElement.nextElementSibling;
                    if (nextTab) {
                        nextTab.querySelector(".nav-link").click();
                    }
                } else {
                    alert("Por favor, completa todos los campos requeridos antes de avanzar.");
                }
            });
        });

        document.querySelectorAll(".previous-step").forEach(button => {
            button.addEventListener("click", function() {
                const activeTab = document.querySelector(".tab-pane.active");
                const prevTab = document.querySelector(`.nav-link[href="#${activeTab.id}"]`).parentElement.previousElementSibling;
                if (prevTab) {
                    prevTab.querySelector(".nav-link").click();
                }
            });
        });
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

@section('js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const fechaInput = document.getElementById("fecha");


    const fechaHoy = new Date();
    ajustarFecha(fechaHoy);
    actualizarTipoSesion(fechaHoy);


    fechaInput.addEventListener("change", function() {
        const fechaSeleccionada = new Date(fechaInput.value + 'T00:00:00');
        ajustarFecha(fechaSeleccionada);
        actualizarTipoSesion(fechaSeleccionada);
    });

    function ajustarFecha(fechaSeleccionada) {
        const dia = fechaSeleccionada.getDate();
        const mes = fechaSeleccionada.toLocaleString('es-ES', { month: 'long' });
        const ano = fechaSeleccionada.getFullYear();

        document.getElementById('diaTexto').innerText = dia;
        document.getElementById('mesTexto').innerText = mes;
        document.getElementById('anoTexto').innerText = ano;
    }

    function actualizarTipoSesion(fechaSeleccionada) {
        const dia = fechaSeleccionada.getDate();


        const tipoSesion = (dia >= 1 && dia <= 5) || (dia >= 15 && dia <= 20) ? 'Ordinaria' : 'Extraordinaria';


        document.getElementById('tipoSesion').innerText = tipoSesion;
    }
});

</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar el stepper
        new Stepper(document.querySelector('.nav-pills'));

        // Inicializar Select2
        $('#id_libros').select2();

        // Inicializar Summernote
        $('#motivo_ausencia').summernote({
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


        function validateMotivoAusencia() {
            const checkboxesAusentes = document.querySelectorAll('input[name="personal[]"]:checked');
            const motivoAusenciaField = $('#motivo_ausencia');


            if (checkboxesAusentes.length === 0) {
                motivoAusenciaField.summernote('disable');
                motivoAusenciaField.summernote('code', '');
            } else {
                motivoAusenciaField.summernote('enable');
            }
        }


        document.querySelectorAll('input[name="personal[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', validateMotivoAusencia);
        });


        document.getElementById('selectAll').addEventListener('change', validateMotivoAusencia);


        validateMotivoAusencia();
    });
</script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
    console.log('DOMContentLoaded activado');
    updatePersonalAttendance();
});
function toggleSelectAll() {
    var isSelectAllChecked = document.getElementById('selectAll').checked;
    var checkboxes = document.querySelectorAll('input[name="personal[]"]');
    var isAllPresentesChecked = document.getElementById('selectAllPresentes').checked;
    if (isAllPresentesChecked) {

        checkboxes.forEach(function(checkbox) {
            checkbox.checked = true;
            checkbox.disabled = true;
        });
        document.getElementById('selectAll').checked = false;
        return;
    }


    checkboxes.forEach(function(checkbox) {
        checkbox.disabled = false;
        checkbox.checked = isSelectAllChecked;
    });

    updatePersonalAttendance();
}


    function updatePersonalAttendance() {
        const checkboxes = document.querySelectorAll('input[name="personal[]"]');
        const presentPersonal = document.getElementById('presentPersonal');
        const FaltaPersonal = document.getElementById('FaltaPersonal');

        const selectedNames = [];
        const presentNames = [];


        checkboxes.forEach(checkbox => {
        const label = checkbox.closest('label').innerText.trim();


        if (checkbox.checked) {
            selectedNames.push(label);
        } else {

            presentNames.push(label);
        }
    });
        FaltaPersonal.innerText = selectedNames.length > 0 ? selectedNames.join(', ') : 'Ninguno';
        presentPersonal.innerText = presentNames.length > 0 ? presentNames.join(', ') : 'Ninguno';

    }


    function updateMotivoAusencia() {
    const FaltaPersonal = document.getElementById('FaltaPersonal');
    const motivoAusencia = document.getElementById('motivo_ausencia').value;


    if (motivoAusencia) {
        FaltaPersonal.innerText = motivoAusencia;
    } else {
        FaltaPersonal.innerText = 'Ninguno';
    }
}

    window.addEventListener('DOMContentLoaded', () => {
        simulateCheckboxToggle();
    });
    document.addEventListener("DOMContentLoaded", updatePersonalAttendance);
    document.getElementById('motivo_ausencia').addEventListener('input', updateMotivoAusencia);
</script>
<script>

   flatpickr("#fecha", {
       dateFormat: "Y-m-d",
       allowInput: true,
       position: "auto",

   });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function() {

    document.querySelectorAll(".next-step").forEach(button => {
        button.addEventListener("click", function() {
            const activeTab = document.querySelector(".tab-pane.active");
            const inputs = activeTab.querySelectorAll("input, select, textarea");
            let valid = true;


            inputs.forEach(input => {
                if (input.hasAttribute("required") && !input.value) {
                    valid = false;
                    input.classList.add("is-invalid");
                } else {
                    input.classList.remove("is-invalid");
                }
            });

            if (valid) {

                const nextTab = document.querySelector(`.nav-link[href="#${activeTab.id}"]`).parentElement.nextElementSibling;
                if (nextTab) {
                    nextTab.querySelector(".nav-link").click();
                }
            } else {
                alert("Por favor, completa todos los campos requeridos antes de avanzar.");
            }
        });
    });


    document.querySelectorAll(".previous-step").forEach(button => {
        button.addEventListener("click", function() {
            const activeTab = document.querySelector(".tab-pane.active");
            const prevTab = document.querySelector(`.nav-link[href="#${activeTab.id}"]`).parentElement.previousElementSibling;
            if (prevTab) {

                prevTab.querySelector(".nav-link").click();
            }
        });
    });



});
document.getElementById('form-acta').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log("Datos del formulario:", new FormData(this));

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
        </style>
        <style>

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
#checkboxContainer {
    margin-top: 20px;
    padding-left: 20px;
    border-left: 2px solid #ccc;
    padding-top: 10px;
    padding-bottom: 10px;
}

.small.text-muted {
    font-size: 0.875rem;
    color: #6c757d;
}

         </style>

@stop



