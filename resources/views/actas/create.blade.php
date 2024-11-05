@extends('adminlte::page')

@section('title', 'Crear Acta')

@section('content_header')
    <h1>Crear Acta</h1>
@stop

@section('content')
    <form action="{{ route('actas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_libros">Libro</label>
            <select class="form-control" id="id_libros" name="id_libros" required>
                <option value="">Seleccione un libro</option>
                @foreach ($libros as $libro)
                    <option value="{{ $libro->id }}">{{ $libro->nombre }} ({{ $libro->fecha_inicio }} - {{ $libro->fecha_fin }})</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="personal">Personal</label>
            <div>
                @foreach ($personal as $persona)
                    <label>
                        <input type="checkbox" name="personal[]" value="{{ $persona->id }}" 
                               onchange="updateSelectedPersonal()"> 
                        {{ $persona->nombre }} {{ $persona->apellido }} {{ $persona->cargo }} {{ $persona-> }}
                    </label><br>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="{{ now()->toDateString() }}" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
        </div>

        <div class="form-group">
            <label for="correlativo">Número de Acta</label>
            <input type="text" class="form-control font-weight-bold text-uppercase" id="correlativo" name="correlativo"
                   value="ACTA NÚMERO {{ $correlativo ?? '1' }} DEL CONCEJO MUNICIPAL PLURAL DE LA UNIÓN SUR.-" readonly>
        </div>
        
        <div class="form-group">
            <label>Fecha y Hora de Elaboración</label>
            <p>
                En las instalaciones del Centro Municipal para la Prevención de la Violecia, del distrito de la Unión, 
                Municipio de La Unión Sur, departamento de La Unión, a las {{ now()->translatedFormat('H') }} horas del día 
                {{ now()->format('j') }} de {{ now()->translatedFormat('F') }} del {{ now()->year }}. 
                En avenencia de artículo 31 numeral 10, artículo 31 numeral 10, acrtículo 38, artículo 48, numeral 1 del Código 
                Municipal, en sesión <strong>{{ $tipoSesion }}</strong>,
            </p>
            
            
            <p><strong>Personal Seleccionado:</strong></p>
            <p id="selected-personal"></p>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@stop

@section('js')
<script>
    function updateSelectedPersonal() {
        
        const checkboxes = document.querySelectorAll('input[name="personal[]"]:checked');
        const selectedNames = Array.from(checkboxes).map(checkbox => checkbox.parentNode.textContent.trim());

        
        document.getElementById('selected-personal').textContent = selectedNames.join(', ');
    }
</script>
@stop
