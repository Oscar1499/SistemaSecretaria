<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acuerdo;
use App\Models\Certificacion;
use App\Models\Personal;

class CertificacionController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $certificaciones = Certificacion::all();
        return view('certificacion.index', compact('certificaciones'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        $secretarios = Personal::whereIn('cargo', ['Secretario', 'Secretaria'])->get();
        // Code to show form for creating a new certification
        $acuerdos = Acuerdo::all();

        return view('certificacion.create', compact('acuerdos', 'secretarios'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        try {
            $request->validate([
                'fecha_Certificacion' => 'required|date',
                'contenido_Certificacion' => 'required|string',
            ]);
            $data = $request->only([
                'fecha_Certificacion',
                'contenido_Certificacion',
            ]);

            Certificacion::create($data);
            return redirect()->route('certificacion.index')->with('success_create', 'Certificación creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('certificacion.index')->with('error_create', 'Hubo un error al crear la certificación: ' . $e->getMessage());
        }
    }
    public function obtenerAcuerdos(Request $request)
    {
        try {
            $acuerdo = Acuerdo::findOrFail($request->id_Acuerdo);
            
            // Suponiendo que tienes una relación definida en el modelo Acuerdo
            $acta = $acuerdo->acta; // Esto obtiene el acta relacionada

            return response()->json([
                'descripcion_Acuerdos' => $acuerdo->descripcion_Acuerdos,
                'presentes' => $acta ? $acta->presentes : null // Verifica si acta existe
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Acuerdo no encontrado'], 404);
        }
    }

    // Display the specified resource.
    public function show(Certificacion $certificacion)
    {
        // Code to display a specific certification
        return view('certificacion.show', compact('certificacion'));
    }

    // Show the form for editing the specified resource.
    public function edit(Certificacion $certificacion)
    {
        $acuerdos = Acuerdo::all();
        // Code to show form for editing a specific certification
        return view('certificacion.edit', compact('certificacion', 'acuerdos'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, Certificacion $certificacion)
    {
        try {
            $request->validate([
               'fecha_Certificacion' => 'required|date',
               'contenido_Certificacion' => 'required|string',
           ]);
           $data = $request->only([
               'fecha_Certificacion',
               'contenido_Certificacion',
           ]);
           $certificacion->update($data);
           return redirect()->route('certificacion.index')->with('success_update', 'Actualizado');
           } catch (\Exception $e) {
               //throw $th;
               return redirect()->route('certificacion.index')->with('error_update', 'error ');
           }
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        try {
            Certificacion::destroy($id);
            return redirect()->route('certificacion.index')->with('success_delete', 'Certificación eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('certificacion.index')->with('error_delete', 'Hubo un error al eliminar la certificación: ' . $e->getMessage());
        }
    }
}