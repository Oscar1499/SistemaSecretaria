<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<body>

</body>
<div class="modal fade" id="personalModal" tabindex="-1" aria-labelledby="personalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="personalForm" action="{{ route('personal.store') }}" method="POST" autocomplete="off">
                @csrf
                <input type="hidden" name="_method" value="POST">

                <div class="modal-header">
                    <h5 class="modal-title" id="personalModalLabel"><i class="bi bi-person-fill-add"></i> Agregar / <i class="bi bi-person-fill-gear"></i> Editar Personal</h5>
                    <button type="button" class="close" data-dismiss="modal" onclick="volverAtras()" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre"><i class="bi1 bi-person-fill me-1"></i> Nombre</label>
                        <input type="text" placeholder="Ingrese el nombre completo del personal (Ej: Juan José)" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido"><i class="bi bi-person-lines-fill me-1"></i> Apellido</label>
                        <input type="text" placeholder="Ingrese el apellido completo del personal (Ej: Pérez)" class="form-control" id="apellido" name="apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="genero"><i class="bi1 bi-gender-ambiguous me-1"></i> Genero</label>
                        <select name="genero" id="genero" class="form-control" onchange="generoSeleccionado = this.value">
                            <option value="" selected>Seleccione un genero</option>
                            <option value="hombre">Masculino</option>
                            <option value="mujer">Femenino</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cargo"><i class="bi1 bi-briefcase-fill me-1"></i> Cargo</label>
                        <div class="custom-select-container">
                            <input type="text" id="search-cargo" class="form-control mb-2" placeholder="Buscar o seleccionar..." autocomplete="off">
                            <ul id="cargo-list" class="list-group">
                                <li class="list-group-item" data-value="Alcalde">Alcalde</li>
                                <li class="list-group-item" data-value="Secretario">Secretario</li>
                                <li class="list-group-item" data-value="Síndico">Síndico</li>
                                <li class="list-group-item" data-value="Primer regidor">Primer regidor</li>
                                <li class="list-group-item" data-value="Segundo regidor">Segundo regidor</li>
                                <li class="list-group-item" data-value="Tercer regidor">Tercer regidor</li>
                                <li class="list-group-item" data-value="Cuarto regidor propietario">Cuarto regidor propietario</li>
                                <li class="list-group-item" data-value="Primer regidor">Primer regidor</li>
                                <li class="list-group-item" data-value="Cuarto regidor">Cuarto regidor</li>
                            </ul>
                            <input type="hidden" name="cargo" id="cargo" required>
                        </div>
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const cargoList = document.querySelectorAll("#cargo-list .list-group-item");

                            // Guardar los valores originales en un atributo adicional
                            cargoList.forEach(item => {
                                item.setAttribute("data-original", item.getAttribute("data-value"));
                            });

                            document.getElementById("genero").addEventListener("change", function() {
                                const genero = this.value;

                                const generoMap = {
                                    "Alcalde": "Alcaldesa",
                                    "Secretario": "Secretaria",
                                    "Síndico": "Síndica",
                                    "Primer regidor": "Primera regidora",
                                    "Segundo regidor": "Segunda regidora",
                                    "Tercer regidor": "Tercera regidora",
                                    "Cuarto regidor propietario": "Cuarta regidora propietaria",
                                    "Cuarto regidor": "Cuarta regidora"
                                };

                                // Actualizar dinámicamente los textos y valores
                                cargoList.forEach(item => {
                                    const originalValue = item.getAttribute("data-original");
                                    const femenino = generoMap[originalValue];

                                    if (genero === "mujer" && femenino) {
                                        item.textContent = femenino;
                                        item.setAttribute("data-value", femenino);
                                    } else if (genero === "hombre") {
                                        item.textContent = originalValue;
                                        item.setAttribute("data-value", originalValue);
                                    }
                                });
                            });
                        });
                    </script>

                    <div class="form-group">
                        <label for="rubricas"><i class="bi bi-pencil-fill"></i> Rúbricas</label>
                        <input type="text" class="form-control" id="rubricas" name="rubricas" placeholder="Ingrese las rúbricas" required>
                    </div>
                    <input type="hidden" name="propietario" value="0">
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="propietario" name="propietario" value="1" onchange="togglePropietarioSelect()">
                        <label class="form-check-label" for="propietario"><i class="bi bi-person-fill"></i> Propietario</label>
                    </div>

                    {{-- Select de propietarios, visible solo si "propietario" no está marcado --}}
                    <div class="form-group" id="propietarioSelectContainer" style="display: none;">
                        <label for="propietario_id"><i class="bi bi-check-circle-fill"></i> Seleccionar Propietario</label>
                        <select class="form-control" id="propietario_id" name="propietario_id">
                            <option value="">Seleccione un propietario</option>
                            @foreach($propietarios as $propietario)
                            <option value="{{ $propietario->id_Personal }}">{{ $propietario->nombre }} {{ $propietario->apellido }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="volverAtras()" data-dismiss="modal"><i class="bi bi-x-lg"> </i>Cerrar</button>
                    <button id="guardar" type="button" class="btn btn-primary" onclick="validar_Campos(event); "><i class="bi bi-floppy"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const input = document.getElementById('search-cargo');
    const list = document.getElementById('cargo-list');
    const hiddenInput = document.getElementById('cargo');
    const form = document.querySelector('form');

    // Mostrar lista al hacer foco
    input.addEventListener('focus', () => list.style.display = 'block');

    // Filtrar opciones mientras se escribe
    input.addEventListener('input', () => {
        const filter = input.value.toLowerCase();
        let hasMatch = false;
        list.querySelectorAll('.list-group-item').forEach(item => {
            const isMatch = item.textContent.toLowerCase().includes(filter);
            item.style.display = isMatch ? '' : 'none';
            if (isMatch) hasMatch = true;
        });
        list.style.display = hasMatch ? 'block' : 'none';
        hiddenInput.value = '';
    });

    // Seleccionar opción
    list.addEventListener('click', (e) => {
        if (e.target.matches('.list-group-item')) {
            input.value = e.target.textContent;
            hiddenInput.value = e.target.dataset.value;
            list.style.display = 'none';
        }
    });

    // Cierre del modal
    function volverAtras() {
        $('#personalModal').modal('hide');
    }


    //   Validar campos antes de enviar el formulario
    function validar_Campos(e) {
        e.preventDefault();
        var input = document.querySelector('input[name="nombre"]');
        var input2 = document.querySelector('input[name="apellido"]');
        var input3 = document.querySelector('input[name="cargo"]');
        var input4 = document.querySelector('input[name="rubricas"]');

        if (input.value !== "" && input2.value !== "" && input3.value !== "" && input4.value !== "") {
            document.getElementById('personalForm').submit();
            return true;
        }
        Swal.fire({
            icon: 'warning',
            title: 'Campos Requeridos',
            text: 'Por favor, complete todos los campos',
            confirmButtonText: 'Aceptar',
            showConfirmButton: true,
            timer: 4000,
            toast: true,
            position: 'top-end'
        });
        return false;
    }
</script>

<script>
    function togglePropietarioSelect() {
        const propietarioCheckbox = document.getElementById('propietario');
        const propietarioSelectContainer = document.getElementById('propietarioSelectContainer');
        propietarioSelectContainer.style.display = propietarioCheckbox.checked ? 'none' : 'block';
    }
</script>

<style>
    .custom-select-container {
        position: relative;
    }

    #search-cargo {
        width: 100%;
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }

    #cargo-list {
        max-height: 200px;
        overflow-y: auto;
        display: none;
        /* Ocultamos por defecto */
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        margin: 0;
        padding: 0;
        list-style: none;
        border: 1px solid #ced4da;
        border-top: none;
        background-color: white;
        z-index: 10;
    }

    .list-group-item {
        cursor: pointer;
        padding: 8px;
        font-size: 14px;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>
