<div class="modal fade" id="personalModal" tabindex="-1" aria-labelledby="personalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="personalForm" action="{{ route('personal.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" value="POST">

                <div class="modal-header">
                    <h5 class="modal-title" id="personalModalLabel">Agregar / Editar Personal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="cargo">Cargo</label>
                        <input type="text" class="form-control" id="cargo" name="cargo">
                    </div>
                    <div class="form-group">
                        <label for="rubricas">Rúbricas</label>
                        <input type="text" class="form-control" id="rubricas" name="rubricas" required>
                    </div>
     <input type="hidden" name="propietario" value="0">
<div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="propietario" name="propietario" value="1" onchange="togglePropietarioSelect()">
    <label class="form-check-label" for="propietario">Propietario</label>
</div>

                    {{-- Select de propietarios, visible solo si "propietario" no está marcado --}}
                    <div class="form-group" id="propietarioSelectContainer" style="display: none;">
                        <label for="propietario_id">Seleccionar Propietario</label>
                        <select class="form-control" id="propietario_id" name="propietario_id">
                            <option value="">Seleccione un propietario</option>
                            @foreach($propietarios as $propietario)
                                <option value="{{ $propietario->id_Personal }}">{{ $propietario->nombre }} {{ $propietario->apellido }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePropietarioSelect() {
        const propietarioCheckbox = document.getElementById('propietario');
        const propietarioSelectContainer = document.getElementById('propietarioSelectContainer');
        propietarioSelectContainer.style.display = propietarioCheckbox.checked ? 'none' : 'block';
    }
</script>
