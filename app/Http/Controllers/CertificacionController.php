<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acuerdo;

class CertificacionController extends Controller
{
    // Display a listing of the resource.
    public function index()

    {
        return view('certificacion.index');
    }

    // Show the form for creating a new resource.
    public function create()
    {
        // Code to show form for creating a new certification
        $acuerdos = Acuerdo::all();

        return view('certificacion.create', compact('acuerdos'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Code to store a new certification
    }
    public function obtenerAcuerdos(Request $request)
    {
        try {
            $acuerdo = Acuerdo::findOrFail($request->id_Acuerdo);
            return response()->json(['descripcion_Acuerdos' => $acuerdo->descripcion_Acuerdos]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Acuerdo no encontrado'], 404);
        }
    }

    // Display the specified resource.
    public function show($id)
    {
        // Code to display a specific certification
        return view('certificacion.show');
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $certificacion = Certificacion::findOrFail($id);
        // Code to show form for editing a specific certification
        return view('certificacion.edit', compact('certificacion'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        // Code to update a specific certification
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        // Code to delete a specific certification
    }
}