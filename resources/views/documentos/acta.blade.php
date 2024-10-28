
@extends('layouts.app')

@section('content')
<h1>Acta de la Sesión</h1>

<form action="{{ route('actas.store') }}" method="POST">
    @csrf

  
    <div class="acta-info">
        <label for="libro_id">Libro:</label>
        <select name="libro_id" id="libro_id" class="form-control">
            @foreach($libros as $libro)
                <option value="{{ $libro->id }}">{{ $libro->anio }} - {{ $libro->descripcion }}</option>
            @endforeach
        </select>

        <label for="fecha">Fecha de la Sesión:</label>
        <input type="date" name="fecha" id="fecha" class="form-control" required>

        <label for="descripcion">Descripción de la Sesión:</label>
        <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
    </div>

    <!-- Sección de Acuerdos -->
    <h2>Acuerdos de la Sesión</h2>
    <div id="acuerdos-container">
        <!-- Ejemplo de acuerdo, se duplicará dinámicamente -->
        <div class="acuerdo">
            <label for="descripcion_acuerdo">Descripción del Acuerdo:</label>
            <textarea name="descripcion_acuerdo[]" class="form-control" rows="2"></textarea>

            <label for="tipo_votacion">Tipo de Votación:</label>
            <select name="tipo_votacion[]" class="form-control">
                <option value="unanimidad">Unanimidad</option>
                <option value="mayoria_simple">Mayoría Simple</option>
                <option value="mayoria_calificada">Mayoría Calificada</option>
            </select>

            <label for="votos_favor">Votos a Favor:</label>
            <select name="votos_favor[]" class="form-control" multiple>
                @foreach($personal as $persona)
                    <option value="{{ $persona->id }}">{{ $persona->nombre }} {{ $persona->apellido }}</option>
                @endforeach
            </select>

            <label for="votos_contra">Votos en Contra:</label>
            <select name="votos_contra[]" class="form-control" multiple>
                @foreach($personal as $persona)
                    <option value="{{ $persona->id }}">{{ $persona->nombre }} {{ $persona->apellido }}</option>
                @endforeach
            </select>

            <label for="motivo_contra">Motivo de la Discrepancia:</label>
            <textarea name="motivo_contra[]" class="form-control" rows="2"></textarea>

            <button type="button" class="btn btn-danger remove-acuerdo">Eliminar Acuerdo</button>
        </div>
    </div>

    <button type="button" id="add-acuerdo" class="btn btn-secondary">Agregar Nuevo Acuerdo</button>

    <button type="submit" class="btn btn-primary">Guardar Acta</button>
</form>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addAcuerdoButton = document.getElementById('add-acuerdo');
        const acuerdosContainer = document.getElementById('acuerdos-container');

        // Función para agregar un nuevo acuerdo
        addAcuerdoButton.addEventListener('click', function () {
            const acuerdoTemplate = document.querySelector('.acuerdo').cloneNode(true);
            acuerdoTemplate.querySelector('textarea[name="descripcion_acuerdo[]"]').value = '';
            acuerdoTemplate.querySelectorAll('select').forEach(select => select.selectedIndex = -1);
            acuerdoTemplate.querySelector('textarea[name="motivo_contra[]"]').value = '';
            acuerdoTemplate.querySelector('.remove-acuerdo').addEventListener('click', function () {
                acuerdoTemplate.remove();
            });
            acuerdosContainer.appendChild(acuerdoTemplate);
        });

        // Remover un acuerdo
        document.querySelectorAll('.remove-acuerdo').forEach(button => {
            button.addEventListener('click', function () {
                button.closest('.acuerdo').remove();
            });
        });
    });
</script>
@endpush
