@extends('adminlte::page')

@section('title', 'Crear nuevo Acuerdo')

@section('content_header')
<h1><i class="fas fa-book-open mr-2"></i> Crear Nuevo Acuerdo</h1>
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
?>
<!-- SweetAlert2 (para alertas) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- BS Stepper (para el paso a paso del formulario) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">

<!-- Select2 (para mejorar los selectores de formularios) -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

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
<div class="card container-fluid pt-0">
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
                <form action="" method="POST">
                    @csrf

                    <!-- Paso 1: Configuración del libro-->
                    <div id="step-1" class="content active tab-pane" role="tabpanel" aria-labelledby="stepper-step-1">
                        <div class="form-group">
                            <label for="id_Actas"><i class="bi bi-journal-bookmark-fill"></i> Acta</label>
                            <select id="id_Actas" name="id_Actas" class="form-control select2" required onchange="obtenerPresentes(this.value)">
                                <option value="" disabled selected>Seleccione</option>
                                @foreach($actas as $acta)
                                <option value="{{ $acta->id_Actas }}" data-descripcion="{{ $acta->correlativo }}">
                                    {{ $acta->id_Actas }} - {{ $acta->correlativo }}
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
                        <div class="form-group">
                            <label for="correlativo"><i class="bi bi-file-earmark-text me-2"></i> Número de Acta</label>
                            <input type="text" class="form-control font-weight-bold text-uppercase" id="correlativo" name="correlativo"
                                value="ACUERDO NÚMERO {{ strtoupper(numToText($numero_Acuerdo)) }}. El Consejo Municipal de la Unión sur CONSIDERANDO: .-" readonly>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="notas" name="apertura_Libro"></textarea>
                        </div>
                        @section('css')
                        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
                        @endsection

                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary previous-step"><i class="bi bi-arrow-left"></i> Anterior</button>
                            <button type="button" class="btn btn-primary next-step">Siguiente <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>

                    {{-- Paso 3: Apertura del libro --}}
                    <div id="step-3" class="content" role="tabpanel" aria-labelledby="stepper-step-3">
                        <div class="container mt-2">
                            <!-- Botón de Unanimidad -->

                            <button type="button" class="btn btn-info py-2 px-4 shadow-sm" onclick="voto_Unimidad();">
                                <i class="fas fa-users"></i> Voto por Unanimidad
                            </button>
                            <script>
                            </script>
                            <!-- Miembros del Consejo -->
                            <div id="contenedorPresentes" class="row mt-2">
                                <script>
                                    async function obtenerPresentes(idActas) {
                                        if (!idActas) return;

                                        try {
                                            const response = await fetch("{{ route('obtener.presentes') }}", {
                                                method: "POST",
                                                headers: {
                                                    "Content-Type": "application/json",
                                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                                },
                                                body: JSON.stringify({
                                                    id_Actas: idActas
                                                })
                                            });

                                            const data = await response.json();

                                            if (data && Array.isArray(data)) {

                                                const contenedor = document.getElementById('contenedorPresentes');
                                                contenedor.innerHTML = ''; // Limpiar el contenedor antes de insertar

                                                // Reiniciar contadores de votos y texto de los botones de votación
                                                // antes de agregar las tarjetas de los presentes
                                                votosFavor = 0;
                                                votosContra = 0;
                                                document.getElementById('vote-favor').textContent = 'Nadie ha votado a favor';
                                                document.getElementById('vote-contra').textContent = 'Nadie ha votado en contra';

                                                // Iterar sobre los datos (nombres de los presentes)
                                                data.forEach(presente => {
                                                    agregarTarjeta(contenedor, presente);
                                                });
                                            } else {
                                                alert("No se encontraron presentes.");
                                            }
                                        } catch (error) {
                                            console.error("Error al obtener los presentes:", error);
                                        }
                                    }

                                    function resaltarCargos(texto) {
                                        const palabrasClave = [
                                            'Alcalde', 'Alcaldesa', 'Cuarto regidor propietario',
                                            'Cuarta regidora propietaria', 'Tercer regidor', 'Tercera regidora',
                                            'Segundo regidor', 'Segunda regidora', 'Secretario', 'Secretaria',
                                            'Síndico', 'Síndica', 'Primer regidor', 'Primera regidora',
                                            'Cuarto regidor', 'Cuarta regidora'
                                        ];
                                        const regEx = new RegExp(`\\b(${palabrasClave.join("|")})\\b`, "gi");
                                        const match = texto.match(regEx);
                                        return match ? match[0] : 'Ninguno';
                                    }

                                    function agregarTarjeta(contenedor, presente) {
                                        const contenido = `
            <div class="col-md-3 ">
                <div class="card shadow-lg border-0 rounded-3 p-2 h100">
                    <div class="card-body text-center">
                        <div class="mb-2">
                            <i class="fas fa-user-circle fa-5x text-primary"></i>
                        </div>
                        <h6 class="card-title mb-1 text-dark font-weight-bold">
                            ${presente.split(' ').slice(0, 3).join(' ')}
                        </h6>
                        <span class="d-inline-block text-truncate text-center" style="max-width: 197px;">
                            Cargo: ${resaltarCargos(presente)}
                        </span>
                        <div class="btn-group w-100 d-flex justify-content-center" role="group" aria-label="Voto Miembro">
                            <button type="button" style="font-size: 1rem; border-radius: 20px;"
                                class="btn btn-success py-1 shadow-sm mx-1 flex-fill"
                                onclick="toggleVote(this, 'success', '${resaltarCargos(presente)}')">
                                <i class="fas fa-thumbs-up"></i> A favor
                            </button>
                            <button type="button" style="font-size: 1rem; border-radius: 20px;"
                                class="btn btn-danger py-1 shadow-sm mx-1 flex-fill"
                                onclick="toggleVote(this, 'danger', '${resaltarCargos(presente)}')">
                                <i class="fas fa-thumbs-down"></i> En contra
                            </button>
                        </div>
                    </div>
                </div>
            </div>`;

                                        contenedor.insertAdjacentHTML('beforeend', contenido);
                                    }
                                </script>
                            </div>

                            <!-- Resultados de la votación -->
                            <div class="vote-counts text-center d-flex justify-content-between">
                                <div class="left">
                                    <div class="card border-success mb-1">
                                        <div class="card-body d-flex flex-column justify-content-left align-items-center p-3">
                                            <h6 class="card-title text-success">Miembros del Consejo a Favor</h6>
                                            <p id="vote-favor" class="card-text text-success mb-0">Nadie ha votado a favor</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="right">
                                    <div class="card border-danger mb-1">
                                        <div class="card-body d-flex flex-column justify-content-left align-items-center p-3">
                                            <h6 class="card-title text-danger">Miembros del Consejo en contra</h6>
                                            <p id="vote-contra" class="card-text text-danger mb-0">Nadie ha votado en contra</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones de navegación -->
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
</body>

</html>
@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script>
    // Variables de conteo
    let votosFavor = 0;
    let votosContra = 0;

    // Función principal de votación
    function toggleVote(button, type, cargo) {
        let voto = 1; // Valor por defecto del voto
        if (cargo === 'Alcaldesa' || cargo === 'Alcalde') {
            Swal.fire({
                title: '¿Cómo desea votar?',
                text: "Seleccione una opción:",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-check"></i> Voto Simple',
                cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
                showDenyButton: true,
                denyButtonText: '<i class="fas fa-check-double"></i> Voto Doble',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    voto = 1; // Voto simple
                    procesarVoto(button, type, voto);
                } else if (result.isDenied) {
                    voto = 2; // Voto doble
                    procesarVoto(button, type, voto);
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire('Acción cancelada', 'No se realizó ningún voto', 'info');
                }
            });
        } else {
            // Si no es Alcalde/Alcaldesa, procesar directamente con voto simple
            procesarVoto(button, type, voto);
        }
    }

    function voto_Unimidad() {
        const botones = document.querySelectorAll('.btn-group[role="group"] button');
        Swal.fire({
            title: '¿Cómo desea votar?',
            text: "Seleccione una opción:",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-thumbs-up"></i> Unánime a favor',
            confirmButtonColor: '#198754',
            cancelButtonText: '<i class="fas fa-ban"></i> Cancelar',
            showDenyButton: true,
            denyButtonText: '<i class="fas fa-thumbs-down"></i> Unánime en contra',
            denyButtonColor: '#dc3545',
            reverseButtons: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Seleccionar todos los botones "A favor"
                botones.forEach(btn => {
                    if (btn.classList.contains('btn-success')) {
                        btn.innerHTML = '<i class="fas fa-check"></i> A favor';
                        procesarVoto(btn, 'success', 1);
                    } else {
                        btn.innerHTML = '<i class="fas fa-thumbs-down"></i> En contra';
                    }
                });

            } else if (result.isDenied) {
                botones.forEach(btn => {
                    if (btn.classList.contains('btn-danger')) {
                        btn.innerHTML = '<i class="fas fa-check"></i> En contra';
                        procesarVoto(btn, 'danger', 1);
                    } else {
                        btn.innerHTML = '<i class="fas fa-thumbs-up"></i> A favor';
                    }
                });

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire('Acción cancelada', 'No se realizó ningún voto', 'info');
            }
        });
    }

    function procesarVoto(button, type, voto) {

        const buttons = button.parentNode.querySelectorAll('.btn-group[role="group"] button');

        // Restar el voto del botón previamente seleccionado (si existe)
        buttons.forEach(btn => {
            if (btn.classList.contains('selected')) {
                const previoTipo = btn.classList.contains('btn-success') ? 'success' : 'danger';
                const previoVoto = parseInt(btn.dataset.voto || 1);
                if (previoTipo === 'success') {
                    votosFavor -= previoVoto;
                } else if (previoTipo === 'danger') {
                    votosContra -= previoVoto;
                }
                btn.classList.remove('selected');
                btn.disabled = false;
                // Manejar icono individualmente
                btn.innerHTML = previoTipo === 'success' ? '<i class="fas fa-thumbs-up"></i> A favor' : '<i class="fas fa-thumbs-down"></i> En contra';
            }
        });

        // Marcar el botón actual como seleccionado
        button.classList.add('selected');
        button.disabled = true;
        button.dataset.voto = voto; // Guardar el valor del voto en el botón
        // Manejar icono individualmente
        button.innerHTML = type === 'success' ? '<i class="fas fa-check"></i> A favor' : '<i class="fas fa-check"></i> En contra';

        // Actualizar el conteo de votos
        if (type === 'success') {
            votosFavor += voto;
        } else if (type === 'danger') {
            votosContra += voto;
        }

        // Actualizar los textos en el DOM
        document.getElementById('vote-favor').textContent =
            votosFavor > 1 ?
            `${votosFavor} puntos a favor` :
            votosFavor === 1 ?
            '1 punto a favor' :
            'Nadie ha votado a favor';

        document.getElementById('vote-contra').textContent =
            votosContra > 1 ?
            `${votosContra} puntos en contra` :
            votosContra === 1 ?
            '1 punto en contra' :
            'Nadie ha votado en contra';
    }
</script>
<script>
    // Inicialización de Select2
    $(document).ready(function() {
        $('#id_Actas').select2({
            placeholder: 'Seleccione un acta',
            allowClear: true
        });
    });
</script>
<script>
    // Función para actualizar el texto en Summernote
    function actualizarTexto() {
        // Generar el texto dinámico
        const textoInicial = `
            <p><strong>ALCALDÍA MUNICIPAL DE LA UNIÓN SUR, DEPARTAMENTO DE LA UNIÓN,</strong>
            a las  horas y  minutos del día de del año , EL PRIMER CONSEJO MUNICIPAL PLURAL,
            juramentado constitucionalmente para el periodo 2024-2027, AUTORIZA Y HABILITA el presente Libro de Actas de Sesiones,
            debidamente foliado y sellado para que en él se asienten las actas de sesiones que celebre el primer Concejo Municipal Plural de
            La Unión Sur, del departamento de La Unión, durante el periodo de  a diciembre del año

            <p style="text-align: center;"><strong>______________________</strong></p>
            <p style="text-align: center;"><strong>Municipal</strong></p>

            <p style="text-align: center;"><strong>______________________</strong></p>
            <p style="text-align: center;"><strong>Municipal</strong></p>
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
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });


        // Actualizar el contenido de Summernote al cargar la página
        actualizarMesYTexto();
    });
</script>

@endsection

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