<?php

namespace App\Http\Controllers;
use App\Models\Personal;
use App\Models\Acta;
use App\Models\Libro;
use Illuminate\Http\Request;

class ActaController extends Controller
{
    public function index()
    {
        $actas = Acta::all();
        return view('actas.index', compact('actas'));
    }

    public function create()
    {
        $anioActual = date('Y'); 

    $libros = Libro::where('anio', $anioActual)->get(); 

    
    if ($libros->isEmpty()) {
        return back()->withErrors(['No hay libros disponibles para el año actual.']);
    }

        $libroActual = $libros->first();
        
        $dia = now()->day;
        $tipoSesion = ($dia >= 1 && $dia <= 5) || ($dia >= 15 && $dia <= 20) ? 'Ordinaria' : 'Extraordinaria';
        $alcaldesa = Personal::where('cargo', 'Alcaldesa')->first(); 
        $secretario = Personal::where('cargo', 'Secretario')->first(); 
        $personal = Personal::all(); 
        

    return view('actas.create', compact('libros','libroActual', 'tipoSesion', 'personal', 'alcaldesa', 'secretario',));

    }
    

    public function store(Request $request)
    {
        $currentYear = now()->year;
    
        
        $validBook = Libro::where('id_Libros', $request->id_libros)
            ->where('anio', $currentYear)
            ->exists();
    
        if (!$validBook) {
            return back()->withErrors(['El libro no está activo para el año actual.']);
        }
    
        
        $request->validate([
            'id_libros' => 'required|exists:libros,id_Libros',
            'fecha' => 'required|date',
            'descripcion' => 'nullable|string',
            'tipo_sesion' => 'required|string',  
            'alcaldesa' => 'required|string',  
            'secretario' => 'required|string'  
        ]);
    
     
        $correlativo = Acta::whereYear('fecha', $currentYear)->count() + 1;
    
      
        $contenido_elaboracion = "En las instalaciones del Centro Municipal para la Prevención de la Violencia, del distrito de la Unión, 
        Municipio de La Unión Sur, departamento de La Unión, a las " . now()->translatedFormat('H') . " horas del día " .
        now()->format('j') . " de " . now()->translatedFormat('F') . " del " . now()->year . ".
        En avenencia de artículo 31 numeral 10, artículo 38, artículo 48, numeral 1 del Código Municipal, en sesión <strong>" . 
        $request->tipo_sesion . "</strong>, convocada y presidida por <strong>" . $request->alcaldesa .
        " Municipal de La Unión Sur</strong>, con el infrascrito Secretario Municipal, <strong>" . $request->secretario .
        "</strong>; presentes los miembros del Concejo Municipal Plural de La Unión.";
    
       
        $acta = new Acta();
        $acta->id_libros = $request->id_libros;
        $acta->fecha = $request->fecha;
        $acta->descripcion = $request->descripcion;
        $acta->numero_acta = $correlativo;
        $acta->tipo_sesion = $request->tipo_sesion;
        $acta->contenido_elaboracion = $contenido_elaboracion; 
        $acta->save();
    
        return redirect()->route('actas.index')->with('success', 'Acta guardada exitosamente.');
    }
    

    public function show(Acta $acta)
    {
        $acuerdos = $acta->acuerdos; 
        return view('actas.show', compact('acta', 'acuerdos'));
    }

    public function edit(Acta $acta)
    {
        $libros = Libro::all(); 
        return view('actas.edit', compact('acta', 'libros'));
    }

    public function update(Request $request, Acta $acta)
    {
        $request->validate([
            'id_libros' => 'required|exists:libros,id', 
            'fecha' => 'required|date',
            'descripcion' => 'nullable|string',
        ]);

        $acta->fill($request->all());
        $acta->tipo_sesion = $acta->definirTipoSesion(); 
        $acta->save();

        return redirect()->route('actas.show', $acta->id)->with('success', 'Acta actualizada exitosamente.');
    }

    public function destroy(Acta $acta)
    {
        $acta->delete();
        return redirect()->route('libros.index')->with('success', 'Acta eliminada exitosamente.');
    }

   
}


