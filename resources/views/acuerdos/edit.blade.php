@extends('adminlte::page')

@section('title', 'Editar Acuerdo')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
<h1><i class="bi bi-file-earmark-text-fill me-2"></i>Editar Acuerdo</h1>
    <a href="{{ route('acuerdos.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle me-1"></i> Regresar
    </a>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
@stop

@section('content')
<!-- SweetAlert2 (para alertas) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

<!-- BS Stepper (para el paso a paso del formulario) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">

<!-- Select2 (para mejorar los selectores de formularios) -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<!-- Bootstrap (framework de diseño) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Moment.js (para manejo de fechas y horas) -->
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

<!-- Flatpickr (para selección de fechas con calendario) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Bootstrap Icons (iconos adicionales para Bootstrap) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<body>
    <div class="card container-fluid pt-0">
        <div class="card-body px-0">
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
                            <span class="bs-stepper-label">Seleccionar Acta</span>
                        </button>
                    </div>
                    <div class="line"></div>

                    <!-- Paso 2 -->
                    <div class="step" data-target="#step-2">
                        <button type="button" class="step-trigger" role="tab" id="stepper-step-3" aria-controls="step-3">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">Selección de Personal</span>
                        </button>
                    </div>
                    <div class="line"></div>

                    <!-- Paso 3 -->
                    <div class="step" data-target="#step-4">
                        <button type="button" class="step-trigger" role="tab" id="stepper-step-4" aria-controls="step-4">
                            <span class="bs-stepper-circle">3</span>
                            <span class="bs-stepper-label">Previsualización y acuerdos</span>
                        </button>
                    </div>
                </div>
                <input type="hidden" id="tipo_sesion_input" name="tipo_sesion_input">

                <div class="bs-stepper-content">
                    <!-- Formulario con pasos -->
                    <form action="{{ route('acuerdos.update', $acuerdo->id_Acuerdo) }}" method="POST" id="acuerdoForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="1" name="id_Personal" id="id_Personal" value="1" required />

                        <!-- Paso 1: Configuración del libro -->
                        <div id="step-1" class="content active tab-pane" role="tabpanel" aria-labelledby="stepper-step-1">
                            <div class="form-group">
                                <label for="fecha_Acuerdos">
                                    <i class="bi bi-calendar-event me-2"></i>
                                    Fecha de acuerdos
                                </label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="fecha_Acuerdos" name="fecha_Acuerdos" value="{{$acuerdo->fecha_Acuerdos}}" required />
                                    <span class="input-group-text">
                                        <i class="bi bi-calendar-plus"></i>
                                    </span>
                                </div>
                            </div>
                           <div class="form-group">
                               <label for="id_Actas"><i class="bi bi-journal-bookmark-fill"></i>Seleccionar Acta</label>
                               <select id="id_Actas" name="id_Actas" class="form-control select2" required onchange="obtenerPresentes(this.value); let idActa_Variable = obtenerID(this.value)">
                                   <option value="" disabled>Seleccione</option>
                                   @foreach($actas as $acta)
                                       <option value="{{ $acta->id_Actas }}" data-descripcion="{{ $acta->correlativo }}" data-valor2="{{ Str::words($acta->correlativo, 3, '') }}" 
                                           {{ $acuerdo->id_Actas == $acta->id_Actas ? 'selected' : '' }}>
                                           {{ $acta->id_Actas }} - {{ $acta->correlativo }}
                                       </option>
                                   @endforeach
                               </select>
                           </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-primary next-step">Siguiente <i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>


                        <!-- Paso 3: Selección de Personal -->
                        <div id="step-3" class="content" role="tabpanel" aria-labelledby="stepper-step-3">
                            <div class="container mt-1">
                                <!-- Botón de Unanimidad -->
                                <button type="button" class="btn btn-info py-2 px-4 shadow-sm" onclick="voto_Unimidad();">
                                    <i class="fas fa-users"></i> Voto por Unanimidad
                                </button>
                                <!-- Miembros del Consejo -->
                                <div id="contenedorPresentes" class="row mt-1"></div>
                                <!-- Resultados de la votación -->
                                <div class="vote-counts text-center d-flex justify-content-around mt-1">
                                    <div class="card border-success mb-1 mx-2">
                                        <div class="card-body d-flex flex-column justify-content-center align-items-center p-3">
                                            <h6 class="card-title text-success">Miembros a Favor</h6>
                                            <p id="vote-favor" class="card-text text-success mb-0">Nadie ha votado a favor</p>
                                        </div>
                                    </div>
                                    <div class="card border-secondary mb-1 mx-2">
                                        <div class="card-body d-flex flex-column justify-content-center align-items-center p-3">
                                            <h6 class="card-title text-secondary">Tipo de sesión</h6>
                                            <p id="tipo-sesion" class="card-text text-secondary mb-0"></p>
                                            <input type="hidden" id="tipo_sesion_input" name="tipo_sesion" value="Indefinido">
                                        </div>
                                    </div>
                                    <div class="card border-danger mb-1 mx-2">
                                        <div class="card-body d-flex flex-column justify-content-center align-items-center p-3">
                                            <h6 class="card-title text-danger">Miembros en Contra</h6>
                                            <p id="vote-contra" class="card-text text-danger mb-0">Nadie ha votado en contra</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Botones de navegación -->
                                <div class="mt-3 d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary previous-step"><i class="bi bi-arrow-left"></i> Anterior</button>
                                    <button type="button" class="btn btn-primary next-step">Siguiente <i class="bi bi-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- Paso 4: Previsualización del Acuerdo -->
                        <div id="step-4" class="content" role="tabpanel" aria-labelledby="stepper-step-4">
                            <div class="form-group mb-3 d-flex justify-content-between align-items-center">
                                <label for="correlativo" class="mb-0"><i class="bi bi-eye-fill me-2"></i>Previsualización del contenido del Acuerdo</label>
                            </div>
                            <div class="form-group mb-3">
                                <textarea class="form-control" id="contenido" name="descripcion_Acuerdos" rows="6" required></textarea>
                            </div>
                            <input type="hidden" name="motivo_Votacion" id="motivo_Votacion" required />
                            <div class="mt-3 d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary previous-step"><i class="bi bi-arrow-left"></i> Anterior</button>
                                <button type="submit" class="btn btn-primary" onclick="submitForm()" id="btnGuardar">
                                    <i class="bi bi-floppy"></i> Guardar Acuerdo
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script>
    // Función para actualizar el texto en Summernote
    function actualizarTexto() {
        const tipoSesion = $('#tipo-sesion').text().toUpperCase() || 'INDEFINIDO';

        const Textoinicial = `<p style="text-align: justify; line-height: 1.5;"><strong>ACUERDO NÚMERO .-</strong>EL CONSEJO MUNICIPAL, en uso de sus
         facultades legales que les confiere la Constitución de la República de El Salvador en el artículo 204 lnc. 3 CN y
         Código Municipal en su artículo 32 y 34 CM; CONSIDERANDO:<?php echo $contenidoNotas  ?> <strong>.-POR
         TANTO ESTE CONCEJO MUNICIPAL DE ALCALDESA Y CONCEJO MUNICIPAL POR VOTACIÓN ${tipoSesion} ACUERDAN:</strong>
         escriba aquí los acuerdos...</p>`;

        $('#contenido').summernote('code', Textoinicial);
    }

    // Inicializar Summernote
    $('#contenido').summernote({
        height: 400,
        lang: 'es-ES',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['Arial', 'Courier New', 'Times New Roman']],
            ['fontsize', ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph', 'height']],
            ['table', ['table']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    // Evento para detectar cambios en el editor #notas y actualizar #contenido
    $('#notas').on('summernote.change', function(we, contents) {
        actualizarTexto(); // Actualiza el texto en #contenido
    });

    // Actualizar el contenido al cargar la página
    actualizarTexto();
</script>
<script>
    function capturarJustificaciones() {
        const resultados = new Map(); // Usar un Map para manejar entradas únicas por ID

        // Seleccionar todas las tarjetas
        document.querySelectorAll('.card').forEach(card => {
            // Encontrar el textarea de justificación
            const textarea = card.querySelector('.motivo-justificacion');
            if (!textarea) return;

            // Encontrar los botones de voto
            const botonesVoto = card.querySelectorAll('.voto-btn');

            const id = textarea.getAttribute('data-id');
            const texto = textarea.value.trim();

            // Determinar el voto
            let voto = 'Sin voto';
            let ultimoVoto = null;

            botonesVoto.forEach(boton => {
                if (boton.classList.contains('selected')) {
                    ultimoVoto = boton;
                }
            });

            // Usar el último voto seleccionado
            if (ultimoVoto) {
                voto = ultimoVoto.classList.contains('btn-success') ? 'A favor' : 'En contra';
            }

            // Si hay justificación o voto, agregar al resultado
            if (texto || voto !== 'Sin voto') {
                // Añadir el voto al inicio de la justificación si no está presente
                const justificacionConVoto = voto !== 'Sin voto' && !texto.toLowerCase().startsWith(voto.toLowerCase())
                    ? `${voto}: ${texto}`
                    : texto;

                // Crear una entrada única, sobrescribiendo entradas anteriores para el mismo ID
                const entradaUnica = `${id}: Voto=${voto}, Justificación=${justificacionConVoto}`;

                // Guardar solo la última entrada para cada ID
                resultados.set(id, entradaUnica);
            }
        });

        // Convertir el Map a un array de resultados
        const resultadosFinales = Array.from(resultados.values());

        // Establecer el campo de entrada oculto con los resultados concatenados
        const motivoVotacionInput = document.getElementById('motivo_Votacion');
        if (motivoVotacionInput) {
            motivoVotacionInput.value = resultadosFinales.join('|');
            console.log('Resultados capturados:', motivoVotacionInput.value);
        }
    }

    // Asociar la captura de justificaciones al envío del formulario
    document.addEventListener('DOMContentLoaded', function() {
        const acuerdoForm = document.getElementById('acuerdoForm');
        if (acuerdoForm) {
            acuerdoForm.addEventListener('submit', function(event) {
                capturarJustificaciones();
            });
        }
    });
</script>
<script>
    var numPresentes = 0;
    var motivo_Acuerdo = "Este acuerdo Fue tomado por";

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
                votosFavor = 0;
                votosContra = 0;
                numPresentes = data.length;
                document.getElementById('vote-favor').textContent = 'Nadie ha votado a favor';
                document.getElementById('vote-contra').textContent = 'Nadie ha votado en contra';
                document.getElementById('tipo-sesion').textContent = motivo_Acuerdo + " Indefinido";

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
        // Obtener el comentario existente si existe
        const comentarioExistente = <?php echo json_encode($comentarios); ?>[presente] || '';
        
        const contenido = `
<div class="col-md-3 justify-content-center">
  <div class="card shadow-lg border-0 rounded-3 p-1 d-flex flex-column justify-content-between">
    <div class="card-body text-center d-flex flex-column align-items-center">

      <!-- Ícono -->
      <div class="icon-container mb-1">
        <i class="fas fa-user-circle fa-5x text-primary"></i>
      </div>

      <!-- Nombre y cargo alineados -->
      <div class="info-container text-center w-100">
        <!-- Nombre -->
        <strong>
        <h6>
          ${presente.split(' ').slice(0, 2).join(' ')}
        </h6>
        </strong>

        <!-- Cargo -->
        <div 
          class="cargo-container text-muted cargo-text" 
          style="font-size: 1rem; line-height: 1.3; max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
          Cargo: ${resaltarCargos(presente)}
        </div>
      </div>

      <!-- Botones de votación -->
      <div class="btn-group w-100 mt-2 mb-2" role="group" aria-label="Voto Miembro">
        <button
          type="button"
          class="btn btn-sm btn-success voto-btn mx-1"
          onclick="toggleVote(this, 'success', '${resaltarCargos(presente)}')">
          <i class="fas fa-thumbs-up"></i> A favor
        </button>
        <button
          type="button"
          class="btn btn-sm btn-danger voto-btn"
          onclick="toggleVote(this, 'danger', '${resaltarCargos(presente)}')">
          <i class="fas fa-thumbs-down"></i> En contra
        </button>
      </div>
    </div>

    <!-- Justificación -->
  <textarea
  class="form-control w-100 mt-1 motivo-justificacion"
  rows="4"
  id="motivo_Votacion_${presente}"
  name="motivo_Votacion1"
  placeholder="Escriba su justificación del voto aquí..."
  data-id="${presente}"
  required
  >${comentarioExistente}</textarea>

  </div>
</div>
`;
        contenedor.insertAdjacentHTML('beforeend', contenido);
    }

    let votosFavor = 0;
    let votosContra = 0;
    var voto_mayoria_calificada = "";

    // Función principal de votación
    function toggleVote(button, type, cargo) {
        // Verificar si el botón ya está seleccionado
        const isAlreadySelected = button.classList.contains('selected');

        let voto = 1; // Valor por defecto del voto
        if (cargo === 'Alcaldesa' || cargo === 'Alcalde') {
            // Si los votos están empatados o el botón ya está seleccionado
            if (votosFavor === votosContra && isAlreadySelected) {
                Swal.fire({
                    title: '¿Cómo desea votar?',
                    text: isAlreadySelected ? "Elija el tipo de voto:" : "Seleccione una opción:",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fas fa-check"></i> Voto Simple',
                    cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
                    showDenyButton: true,
                    denyButtonText: '<i class="fas fa-check-double"></i> Voto Doble',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Voto Simple
                        voto = 1;
                        voto_mayoria_calificada = "Voto_Simple";
                        procesarVoto(button, type, voto);
                    } else if (result.isDenied) {
                        // Voto Doble
                        voto = 2;
                        voto_mayoria_calificada = "Voto_Doble";
                        procesarVoto(button, type, voto);
                    }
                });
            } else {
                // Si no son iguales, procesar directamente con voto simple
                procesarVoto(button, type, voto);
            }
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
            }
        });
    }

    function procesarVoto(button, type, voto) {
        const buttons = button.parentNode.querySelectorAll('.btn-group[role="group"] button');

        // Obtener el cargo del elemento padre
        const cargoText = button.closest('.card-body').querySelector('.cargo-text').textContent;
        const cargo = cargoText.split(': ')[1].trim();

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
        // Solo bloquear el botón si NO es alcalde o alcaldesa
        if (cargo !== 'Alcalde' && cargo !== 'Alcaldesa') {
            button.disabled = true;
        }
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

        var motivo_Acuerdo = "Este acuerdo fue tomado por";

        let tipoSesion = '';
        if (votosFavor === numPresentes || votosContra === numPresentes) {
            tipoSesion = "Unanimidad";
        } else if (votosFavor === votosContra) {
            tipoSesion = "Mayoría Calificada";
        } else if (votosFavor > (numPresentes / 2) || votosContra > (numPresentes / 2)) {
            tipoSesion = "Mayoría Simple";
        } else {
            tipoSesion = "Indefinido";
        }
        document.getElementById('tipo-sesion').textContent = tipoSesion;
        document.getElementById('tipo_sesion_input').value = tipoSesion;
        actualizarTexto();
    }
</script>
<script>
    // Inicialización de Select2
    $(document).ready(function() {
        $('#id_Actas').select2({
            minimumResultsForSearch: 1  // Mantiene la búsqueda activa
        }).on('change', function() {
            // Forzar cierre inmediato
            setTimeout(() => {
                $(this).select2('close');
            }, 0);

            // Llamar a las funciones existentes
            obtenerPresentes(this.value);
            let idActa_Variable = obtenerID(this.value);
        });
    });

    flatpickr("#fecha_Acuerdos", {
        dateFormat: "Y-m-d",
        allowInput: true,
        defaultDate: new Date(new Date().getFullYear(), 0, 1),
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