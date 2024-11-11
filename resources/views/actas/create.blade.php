@extends('adminlte::page')

@section('title', 'Crear Acta')

@section('content_header')
    <h1>Crear Acta</h1>
@stop

@section('content')
    <form id="form-acta" action="{{ route('actas.store') }}" method="POST">
        @csrf
     
        <div class="steps">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="#step-1" data-toggle="pill">Libro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-2" data-toggle="pill">Fecha</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-3" data-toggle="pill">Funcionarios Presentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-4" data-toggle="pill">Funcionarios Ausentes</a>
                </li>
            </ul>
        </div>

        
        <div class="tab-content">
         
            <div class="tab-pane active" id="step-1">
                <div class="form-group">
                    <label for="id_libros">Libro</label>
                    <select class="form-control" id="id_libros" name="id_libros" required>
                        <option value="">Seleccione un libro</option>
                        @foreach ($libros as $libro)
                            <option value="{{ $libro->id }}" {{ $libro->id === $libroActual->id ? 'selected' : '' }}>
                                {{ $libro->nombre }} ({{ $libro->anio }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            
            <div class="tab-pane" id="step-3">
                <div class="form-group">
                    <label for="personal" >Personal</label>
                    <div class="form-check">
                    <label class="form-check-label">
                <input type="checkbox" class="form-check-input" id="selectAll" onchange="toggleSelectAll()"> 
                Seleccionar Todos
            </label><br>
                        @foreach ($personal as $persona)
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="personal[]" value="{{ $persona->id }}" onchange="updatePersonalAttendance()"> 
                                {{ $persona->nombre }} {{ $persona->apellido }} {{ $persona->cargo }} 
                                           <small class="text-muted">({{ $persona->propietario ? 'Suplente' : 'Propietario' }})</small>
                            </label><br>
                        @endforeach
                    </div>
                </div>
            </div>


            
            <div class="tab-pane" id="step-2">
                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ now()->toDateString() }}" required>
                </div>
                <div class="form-group">
                    <label for="correlativo">Número de Acta</label>
                    <input type="text" class="form-control font-weight-bold text-uppercase" id="correlativo" name="correlativo"
                           value="ACTA NÚMERO {{ $correlativo ?? '1' }} DEL CONCEJO MUNICIPAL PLURAL DE LA UNIÓN SUR.-" readonly>
                </div>
            </div>

            
            <div class="tab-pane" id="step-4">
                <div class="form-group">
                    <label>Fecha y Hora de Elaboración</label>
                    <p>
                        En las instalaciones del Centro Municipal para la Prevención de la Violencia, del distrito de la Unión, 
                        Municipio de La Unión Sur, departamento de La Unión, a las {{ now()->translatedFormat('H') }} horas del día 
                        {{ now()->format('j') }} de {{ now()->translatedFormat('F') }} del {{ now()->year }}. 
                        En avenencia de artículo 31 numeral 10, artículo 38, artículo 48, numeral 1 del Código 
                        Municipal, en sesión <strong>{{ $tipoSesion }}</strong>, convocada y presidida por 
                        <strong>{{ $alcaldesa ? $alcaldesa->nombre . ' ' . $alcaldesa->apellido . ' ' . $alcaldesa->cargo : 'No definida' }}
                        Municipal de La Unión Sur</strong>, con el infrascrito Secretario Municipal, 
                        <strong>{{ $secretario ? $secretario->nombre . ' ' . $secretario->apellido : 'No definida' }}</strong>; 
                        presentes los miembros del Concejo Municipal Plural de La Unión: <a id="presentPersonal"></a> 
                        <strong>y Ausencia de: <a id="FaltaPersonal"></a>.</strong>
                    </p>
                </div>
                <div class="form-group">
                    <label for="motivo_ausencia">Motivo de Ausencia</label>
                    <textarea class="form-control" id="motivo_ausencia" name="motivo_ausencia" placeholder="Escriba el motivo de ausencia para los que no se marcaron" oninput="updatePersonalAttendance()"></textarea>
                </div>
               
                <div class="form-group text-center">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmationModal">Guardar</button>
                </div>
            </div>
        </div>

        
        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirmar Acción</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Está seguro de que desea guardar esta acta?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Sí, Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('js')
<script>
      function toggleSelectAll() {
        var isChecked = document.getElementById('selectAll').checked;
        var checkboxes = document.querySelectorAll('input[name="personal[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });
        updatePersonalAttendance(); 
    }
    function updatePersonalAttendance() {
        const checkboxes = document.querySelectorAll('input[name="personal[]"]');
        const presentPersonal = document.getElementById('presentPersonal');
        const FaltaPersonal = document.getElementById('FaltaPersonal');
        const motivoAusencia = document.getElementById('motivo_ausencia').value;

        const selectedNames = [];
        const absentNames = [];

        checkboxes.forEach(checkbox => {
            const label = checkbox.closest('label').innerText.trim();
            if (checkbox.checked) {
                selectedNames.push(label);
            } else {
                absentNames.push(label);
            }
        });

        presentPersonal.innerText = selectedNames.length > 0 ? selectedNames.join(', ') : 'Ninguno';
        FaltaPersonal.innerText = absentNames.length > 0 
            ? `${absentNames.join(', ')}. Motivo: ${motivoAusencia}`
            : 'Ninguno';
    }

    document.addEventListener("DOMContentLoaded", updatePersonalAttendance);
</script>
@stop