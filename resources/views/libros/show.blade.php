@extends('adminlte::page')

@section('title', 'Detalles del Libro')

@section('content_header')
<h1><i class="fas fa-book"></i> Detalles del Libro</h1>
@stop
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<body>

</body>
@section('content')
<div class="container-fluid" style="border-radius: 10px;">
    <div class="shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white">
            <h5 class="text-center mb-0">📚 Información del Libro</h5>
        </div>
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Fecha de Inicio:</strong></p>
                    <div class="bg-light rounded p-2">
                        <span id="fechainicio_Libro">{{ $libro->fechainicio_Libro }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <p><strong>Fecha Final:</strong></p>
                    <div class="bg-light rounded p-2">
                        <span id="fechafinal_Libro">{{ $libro->fechafinal_Libro }}</span>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <p><strong>Descripción:</strong></p>
                    <div class="bg-light rounded p-3">
                        <span id="descripcion_Libro">{{ $libro->descripcion_Libro }}</span>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <p><strong>Apertura:</strong></p>
                    <div class="bg-light rounded p-3" style="max-height: 200px; overflow-y: auto;">
                        <span id="apertura_Libro_inicio">{!! htmlspecialchars_decode(e(strstr($libro->apertura_Libro, '.', true) . '.')) !!}</span>
                    <span>{!! htmlspecialchars_decode(e(substr(strstr($libro->apertura_Libro, '.'), 1))) !!}</span>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('libros.index') }}" class="btn btn-secondary px-4 py-2 rounded-pill shadow-sm">
                    <i class="fas fa-arrow-left"></i> Atrás
                </a>
                <button id="export-pdf" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('export-pdf').addEventListener('click', function () {
    // Importar la biblioteca jsPDF desde el objeto global `window.jspdf`
    const { jsPDF } = window.jspdf;

    // Crear una nueva instancia de jsPDF con configuración específica
    const pdf = new jsPDF({
        unit: "px",          // Unidad en píxeles
        format: "a4",        // Formato de la página (A4)
        orientation: "portrait" // Orientación vertical
    });

    // Configurar la fuente y el tamaño inicial
    pdf.setFont("helvetica"); // Tipo de fuente
    pdf.setFontSize(12);      // Tamaño de fuente

    // Obtener el texto inicial desde el elemento HTML con id 'apertura_Libro_inicio'
    const texto = document.getElementById('apertura_Libro_inicio').innerText
        .split('.').shift() + '.'; // Solo toma la primera oración hasta el primer punto.


    const textofinal = `
    ___________________________
    BLANCA VICTORIA GUTIERREZ SALMERÓN
    Alcaldesa Municipal


    ___________________________
    CARLOS MAURICIO HERRAR GONZALES
    Síndico Municipal
    `;

    // Obtener las dimensiones de la página PDF
    const pageWidth = pdf.internal.pageSize.getWidth();  // Ancho de la página
    const pageHeight = pdf.internal.pageSize.getHeight(); // Alto de la página

    // Márgenes laterales y ancho máximo del texto
    const marginX = 20;                    // Espacio desde los bordes laterales
    const maxWidth = pageWidth - (marginX * 2); // Ancho máximo del texto
    const lineHeight = 20;                 // Altura entre líneas de texto

    // Procesar y agregar el texto inicial en la parte superior
    const linesInicial = pdf.splitTextToSize(texto, maxWidth); // Dividir el texto en líneas
    let currentY = 120; // Posición inicial vertical para el texto inicial
    linesInicial.forEach((line, index) => {
        // Dibujar cada línea de texto inicial en el PDF
        pdf.text(line, marginX, currentY + (index * lineHeight));
    });

    // Ajustar la posición vertical después del texto inicial
    currentY += linesInicial.length * lineHeight + 40; // Agregar espacio después del texto inicial

    // Procesar el texto final y calcular su altura total
    const linesFinal = pdf.splitTextToSize(textofinal, maxWidth); // Dividir en líneas
    const textHeightFinal = linesFinal.length * lineHeight;      // Altura total del bloque de texto final

    // Calcular la posición inicial del texto final (cercano al pie de página)
    const startY = pageHeight - textHeightFinal - 170; // Ajusta este valor para mover el texto más arriba o abajo

    // Dibujar el bloque de texto final centrado en la página
    linesFinal.forEach((line, index) => {
        // Calcular el ancho de cada línea para centrarla horizontalmente
        const lineWidth = pdf.getStringUnitWidth(line) * pdf.internal.getFontSize() / pdf.internal.scaleFactor;
        const centeredX = (pageWidth - lineWidth) / 2; // Coordenada X centrada
        pdf.text(line, centeredX, startY + (index * lineHeight)); // Dibujar línea centrada
    });

    // Guardar el archivo PDF con el nombre especificado
    pdf.save('Detalles_Libro.pdf');
});
</script>

@stop
