@extends('adminlte::page')

@section('title', 'Editar Certificación')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-certificate me-2"></i> Editar Certificación</h1>
    <a href="{{ route('certificacion.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Regresar
    </a>
</div>
@stop
<?php
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

?>
@section('content')
<div class="card container-fluid p-0">
    <div class="card-body">
        <!-- Barra de Progreso -->
        <div class="progress mb-0">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 33%;" id="progress-bar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">
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
                        <span class="bs-stepper-label">Acuerdo A Certificar</span>
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
                <form action="{{ route('certificacion.store') }}" method="POST">
                    @csrf

                    <!-- Paso 1: Configuración del libro-->
                    <div id="step-1" class="content active" role="tabpanel" aria-labelledby="stepper-step-1">
                        <div class="form-group">
                            <label for="fecha_Certificacion"><i class="bi bi-calendar-event me-2"></i>Fecha de Certificación</label>
                            <div class="input-group">
                                <input type="date"  oninput="actualizarMesYTexto();" class="form-control" id="fecha_Certificacion" name="fecha_Certificacion" value="{{ old('fecha', now()->toDateString()) }}" required />
                                <span class="input-group-text"><i class="bi bi-calendar-plus"></i></span>
                            </div>
                        </div>

                        <div class="form-group">
                                <label for="id_Acuerdos"><i class="bi bi-file-earmark-fill"></i> Seleccionar Acuerdo</label>
                                <select id="id_Acuerdos" name="id_Acuerdos"  class="form-control select2">
                                    <option value="" disabled selected>Seleccione un Acuerdo A Certificar</option>
                                    @foreach($acuerdos as $acuerdo)
                                    <option value="{{ $acuerdo->id_Acuerdo }}" data-descripcion="{{ $acuerdo->correlativo }}" data-valor2="{{ Str::words($acuerdo->correlativo, 3, '') }}">
                                        {{ $acuerdo->id_Acuerdo }} - {{ $acuerdo->fecha_Acuerdos }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-primary next-step">Siguiente <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>

                    <!-- Paso 2: Representación del consejo -->
                    <div id="step-2" class="content" role="tabpanel" aria-labelledby="stepper-step-2">

                    <div class="mt-3 d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary previous-step"><i class="bi bi-arrow-left"></i> Anterior</button>
                            <button type="button" class="btn btn-primary next-step">Siguiente <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>

                    <!-- Paso 3: Apertura del libro -->
                    <div id="step-3" class="content" role="tabpanel" aria-labelledby="stepper-step-3">
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
                    <textarea class="form-control mt-2" id="Certificacion" name="contenido_Certificacion" required></textarea>
                        <div class="mt-3 d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary previous-step"><i class="bi bi-arrow-left"></i> Anterior</button>
                            <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Guardar Certificación</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
    .select2-container--default .select2-selection--single {
        height: 38px;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-color: #ced4da;
        border-radius: 0.25rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 24px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    let data;
async function obtenerAcuerdo(idAcuerdo) {
    if (!idAcuerdo) return;

    try {
        const response = await fetch("{{ route('obtener.acuerdos') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                id_Acuerdo: idAcuerdo
            })
        });

        if (!response.ok) {
            throw new Error('Error en la solicitud');
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Error al obtener el acuerdo:", error);
    }
}
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#fecha_Certificacion", {
            dateFormat: "Y-m-d",
            allowInput: true,
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

        // Inicialización de Select2
    $(document).ready(function() {
        $('#id_Acuerdos').select2({
            placeholder: 'Seleccione un Acuerdo',
            allowClear: true,
            width: '100%'
        }).on('change', function(e) {
            const selectedValue = $(this).val();
            if (selectedValue) {
                // Cerrar el dropdown inmediatamente
                $(this).select2('close');
                
                // Llamar a obtenerPresentes de manera separada
                $.ajax({
                    url: "{{ route('obtener.presentes') }}",
                    method: 'POST',
                    data: {
                        id_Actas: selectedValue,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        // Manejar la respuesta si es necesario
                        console.log('Presentes obtenidos:', data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener presentes:', error);
                    }
                });
            }
        });
    });

     // Función para extraer el día y el mes del input de fecha
     function obtenerFecha() {
        const fecha = document.getElementById("fecha_Certificacion").value;
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

    async function actualizarTexto() {
    // Obtener la fecha y otros datos
    const fecha = obtenerFecha();
    const diaSeleccionado = numeroAPalabras(fecha?.dia) || 'el día';
    const mesSeleccionadoVariable = fecha?.mes || 'el mes';

    let hora_Seleccionada = $('#horaApertura').val();
    let minutos_Seleccionada = $('#minutosApertura').val();
    let id_Acuerdo = $('#id_Acuerdos').val();

    minutos_Seleccionada = typeof minutos_Seleccionada === 'undefined' || minutos_Seleccionada === '' || minutos_Seleccionada === null ?
        "<?php echo $minutosEnTexto ?>" :
        numeroAPalabras(minutos_Seleccionada);

    hora_Seleccionada = typeof hora_Seleccionada === 'undefined' || hora_Seleccionada === '' || hora_Seleccionada === null ?
        "<?php echo $horaEnTexto; ?>" :
        numeroAPalabras(hora_Seleccionada);

    // Obtener el acuerdo
    const acuerdo = await obtenerAcuerdo(id_Acuerdo); // Cambia el 1 por el ID del acuerdo que necesitas
    const descripcionAcuerdo = acuerdo?.descripcion_Acuerdos || 'No se pudo obtener la descripción del acuerdo';

let Texto2 = `CERTIFÍQUESE Y COMUNÍQUESE.-//////////////////////////////////////
////////////////////////////////////////. Es conforme con su original, con el cu
al fue debidamente confrontada, y para los efectos de Ley se expide la presente 
en el Distrito de La Unión, Municipio de La Unión Sur, Departamento de La Unión,
 a los cinco días del mes de diciembre de dos mil veinticuatro.-

`;

    // Construir el texto inicial
    let TextoInicial = `<p style="text-align: justify; line-height: 1.2; font-family: Arial, sans-serif;">
    La Suscrita secretaria Municipal, previa autorización de la Alcaldesa Municipal CERTIFICA. Que en el 
    Libro de Actas y Acuerdos Municipales que el Concejo Municipal Plural de La Unión Sur, lleva en el año
    <?php echo $anioEnTexto ?>, se encuentra el acta número VEINTICINCO de Sesión Ordinaria, celebrada lugar a 
    las ${hora_Seleccionada} horas con ${minutos_Seleccionada} minutos del día ${diaSeleccionado} de ${mesSeleccionadoVariable} del año <?php echo $anioEnTexto ?>, se encuentra 
    el acuerdo Municipal número UNO, que literalmente dice:
    ////////////////////////////////////////////////////////////////////////////</p>
    ${descripcionAcuerdo}
    <br><br></p> ${Texto2}`; // Aquí se agrega la descripción del acuerdo

    // Agregar texto inicial al editor Summernote
    $('#Certificacion').summernote('code', TextoInicial);
}

    // Función principal: obtiene el mes y actualiza Summernote
    function actualizarMesYTexto() {
        actualizarTexto();
    }

   // Inicialización de Summernote
$(document).ready(function() {
    $('#Certificacion').summernote({
        tabsize: 2,
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']], // Opción para cambiar el tipo de letra
            ['fontsize', ['fontsize']], // Opción para cambiar el tamaño de la fuente
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview']]
        ],
        // Opciones adicionales para personalizar las fuentes y tamaños disponibles
        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana'],
        fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '22', '24', '28', '32', '36', '48', '72']
    });

    // Eventos para actualizar dinámicamente
    $('#fecha_Certificacion, #id_Acuerdos, #horaApertura, #minutosApertura').on('change', actualizarMesYTexto);

    // Actualizar el contenido de Summernote al cargar la página
    actualizarMesYTexto();
});
        
        const stepper = new Stepper(document.querySelector('.bs-stepper'));
        const progressBar = document.getElementById('progress-bar');

        document.querySelectorAll('.next-step').forEach(button => {
            button.addEventListener('click', () => {
                stepper.next();
                updateProgressBar();
            });
        });

        document.querySelectorAll('.previous-step').forEach(button => {
            button.addEventListener('click', () => {
                stepper.previous();
                updateProgressBar();
            });
        });

        function updateProgressBar() {
            const steps = document.querySelectorAll('.step');
            const activeStepIndex = Math.max(0, Array.from(steps).findIndex(step => step.classList.contains('active')));
            const progressPercent = ((activeStepIndex + 1) / steps.length) * 100;

            progressBar.style.width = `${progressPercent}%`;
            progressBar.setAttribute('aria-valuenow', progressPercent);
            progressBar.textContent = `Paso ${activeStepIndex + 1} de ${steps.length}`;
        }

        // Ensure the first step is active by default
        document.querySelector('.step')?.classList.add('active');
        updateProgressBar();
    });
</script>
@endsection