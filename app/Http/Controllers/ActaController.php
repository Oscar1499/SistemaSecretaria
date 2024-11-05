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
        $libros = Libro::all(); 
       
        $dia = now()->day;
        $tipoSesion = ($dia >= 1 && $dia <= 5) || ($dia >= 15 && $dia <= 20) ? 'Ordinaria' : 'Extraordinaria';
    
       
    $personal = Personal::all(); 

    return view('actas.create', compact('libros', 'tipoSesion', 'personal'));
    }
    

    public function store(Request $request)
    {
        $currentYear = now()->year; 
        $validBook = Libro::where('id', $request->id_libros)
            ->where('fecha_inicio', '<=', now()->toDateString())
            ->where('fecha_fin', '>=', now()->toDateString())
            ->exists();
    
        if (!$validBook) {
            return back()->withErrors(['El libro no está activo para el año actual.']);
        }
    
        $request->validate([
            'id_libros' => 'required|exists:libros,id', 
            'fecha' => 'required|date',
            'descripcion' => 'nullable|string',
        ]);
    
        $correlativo = Acta::whereYear('fecha', $currentYear)->count() + 1;
    
        $acta = new Acta($request->all());
        $acta->numero_acta = $correlativo; 
        $acta->tipo_sesion = $acta->definirTipoSesion(); 
        $acta->save();
    
        
        if ($request->has('personal')) {
            $acta->personal()->sync($request->input('personal'));
        }
    
        return redirect()->route('libros.show', $acta->id_libros)->with('success', 'Acta creada exitosamente.');
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
