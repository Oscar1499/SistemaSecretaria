@extends('adminlte::page')

@section('title', 'Detalles de la Certificación')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-certificate me-2"></i>Detalles del Certificado</h1>
    <a href="{{ route('certificacion.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle me-1"></i> Regresar
    </a>
</div>
@stop

@section('css')
<!-- Bootstrap Icons y estilos adicionales -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">
@stop

@section('content')
<div class="card container-fluid p-0">
    <div class="card-header bg-gradient-primary text-white">
        <h5 class="text-center mb-0">📜 Información del Certificado</h5>
    </div>
    <div class="card-body p-3">
        <!-- Información del Certificado -->
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Fecha de la certificación:</strong></p>
                <div class="bg-light rounded p-2">
                    <span id="fecha_Certificacion">{{ $certificacion->fecha_Certificacion }}</span>
                </div>
            </div>

        <div class="row mb-3 mt-3">
            <div class="col-12">
                <p><strong>Apertura del Certificado:</strong></p>
                <textarea name="Certificacion" id="Certificacion">
                        {!! $certificacion->contenido_Certificacion !!}
                    </textarea>
            </div>
        </div>

        <!-- Botones -->
        <div class="mt-3">
            <button id="export-pdf" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm">
                <i class="fas fa-file-pdf"></i> Descargar PDF
            </button>
        </div>
    </div>
</div>
@stop

@section('js')
<!-- Scripts adicionales -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

<script>
    $(document).ready(function() {
        $('#Certificacion').summernote({
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
                ['insert', ['link', ]],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {}
        });
        $('#export-pdf').click(function(e) {
            e.preventDefault();

            // Obtener el contenido del editor Summernote
            var content = $('#Certificacion').summernote('code');

            // Reemplazar los saltos invisibles con <br> para el PDF
            var formattedContent = content.replace(
                /<p style="display: none;" class="invisible-line"><\/p>/g,
                '<br><br>'
            );

            // Imagen 1: Imagen centrada en la parte superior
            var imageHTML1 = `
    <div style="text-align: left; margin-bottom: 20px;">
        <img src="{{ asset('img/imagen1.png') }}" alt="Imagen" style="max-width: 250px; height: 120px; margin-left: 1px;">
    </div>
    <p style="text-align: center; line-height: 1.5;font-size: 0.5em; margin: 0;">BLANCA VICTORIA GUTIERREZ SALMERON </p>
    
    <div style="text-align: left; margin-bottom: 20px;">
    <img src="https://media.gettyimages.com/id/1500448395/es/foto/cat-taking-a-selfie.jpg?s=1024x1024&w=gi&k=20&c=A4HkIB60XY8y6xlZzYQayyYusF8Sjn1udnF0kUxEgvk=" alt="Imagen 2" style="
        max-width: 150px;
        height: 100px;
        margin-top: -200px;
        margin-left: 540px;">
    </div>
    `;
            formattedContent = imageHTML1 + formattedContent;

            // Crear un contenedor temporal para el contenido con formato
            var tempContainer = $(
                '<div style="width: 90%; margin: 0 auto; text-align: center; word-break: break-word; position: relative;">'
            ).html(formattedContent);

            // Exportar a PDF usando html2pdf con mayor calidad
            html2pdf()
                .set({
                    margin: 10, // Márgenes en milímetros
                    filename: 'apertura-libro.pdf',
                    html2canvas: {
                        scale: 6, // Escala más alta para mejorar la calidad
                        useCORS: true // Permite cargar imágenes externas
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'portrait' // Orientación vertical
                    }
                })
                .from(tempContainer[0])
                .save();
        });

    });


    </script>
@endsection