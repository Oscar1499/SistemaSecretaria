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
    $request->validate([
        'id_libros' => 'required|integer',
        'id_Personal' => 'required|integer',
        'fecha' => 'required|date',
        'descripcion' => 'nullable|string',
        'correlativo' => 'required|string|max:255',
        'motivo_ausencia' => 'required|string',
        'contenido_elaboracion' => 'required|string',
        'presentes' => 'required|string',
        'ausentes' => 'required|string',
        'tipo_sesion' => 'required|string'
    ]);

   
    $acta = new Acta();
    $acta->id_libro = $request->id_libros;
    $acta->fecha = $request->fecha;
    $acta->motivo_ausencia = $request->motivo_ausencia;
    $acta->correlativo = $request->correlativo ?? 'ACTA NÚMERO ' . rand(1, 100) . ' DEL CONCEJO MUNICIPAL';  
    $acta->save();

    
    foreach ($request->personal as $personaId) {
         $acta->personal()->attach($personaId);
    }

    return redirect()->route('actas.index')->with('success', 'Acta creada exitosamente');
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


