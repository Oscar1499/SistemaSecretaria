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
                    <a class="nav-link" href="#step-3" data-toggle="pill">Funcionarios Ausentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#step-4" data-toggle="pill">Motivo</a>
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
                        <label for="personal"></label>
                        
                        
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
                            </div>
                        </div>
                    </div>
                </div>




            <div class="tab-pane" id="step-2">
                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ now()->toDateString() }}" required>
                </div>
                
            </div>

            <div class="tab-pane" id="step-4">
                <div class="form-group">
                    <div class="form-group">
                    <label for="correlativo">Número de Acta</label>
                    <input type="text" class="form-control font-weight-bold text-uppercase" id="correlativo" name="correlativo"
                           value="ACTA NÚMERO {{ $correlativo ?? '1' }} DEL CONCEJO MUNICIPAL PLURAL DE LA UNIÓN SUR.-" readonly>
                </div>
                    <p>
                        En las instalaciones del Centro Municipal para la Prevención de la Violencia, del distrito de la Unión, 
                        Municipio de La Unión Sur, departamento de La Unión, a las {{ now()->translatedFormat('H') }} horas del día 
                        {{ now()->format('j') }} de {{ \Carbon\Carbon::now()->locale('es')->translatedFormat('F') }} del {{ now()->year }}. 
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
                    <textarea class="form-control" id="motivo_ausencia" name="motivo_ausencia" placeholder="Escriba el motivo de ausencia para los que no se marcaron" oninput="updateMotivoAusencia()"></textarea>
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
<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
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
    });
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
    
    if (FaltaPersonal.innerText !== 'Ninguno') {
        
        if (motivoAusencia) {
            FaltaPersonal.innerText = FaltaPersonal.innerText.replace(/\. Motivo: .*/, "") + `. Motivo: ${motivoAusencia}`;
        } else {
         
            FaltaPersonal.innerText = FaltaPersonal.innerText.replace(/\. Motivo: .*/, "");
        }
    }
}



    document.addEventListener("DOMContentLoaded", updatePersonalAttendance);


    document.getElementById('motivo_ausencia').addEventListener('input', updateMotivoAusencia);
</script>


@stop



@section('css')
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



