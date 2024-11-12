<?php

namespace App\Http\Controllers;

use App\Models\Acuerdo;
use Illuminate\Http\Request;
use App\Models\Acta;
use App\Models\Personal;

class AcuerdoController extends Controller
{
    // Método para mostrar la vista de índice con los acuerdos
    public function index()
    {
        $acuerdos = Acuerdo::all();
        return view('acuerdos.index', compact('acuerdos'));
    }

    // Método para mostrar el formulario de creación
    public function create()
    {
        // Obtén las actas y el personal disponibles en la base de datos
        $actas = Acta::all(); // Asegúrate de tener el modelo `Acta` definido
        $personal = Personal::all(); // Asegúrate de tener el modelo `Personal` definido

        // Envía las variables a la vista
        return view('acuerdos.create', compact('actas', 'personal'));
    }


    // Método para almacenar un nuevo acuerdo
    public function store(Request $request)
    {
        $request->validate([
            'id_Actas' => 'required|integer',
            'id_Personal' => 'required|integer',
            'fecha_Acuerdos' => 'required|date',
            'descripcion_Acuerdos' => 'nullable|string',
        ]);

        Acuerdo::create($request->all());

        return redirect()->route('acuerdos.index')->with('success', 'Acuerdo creado exitosamente.');
    }
}
