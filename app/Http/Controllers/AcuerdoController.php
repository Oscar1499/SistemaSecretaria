<?php

namespace App\Http\Controllers;

use App\Models\Acta;
use App\Models\Acuerdo;
use App\Models\Personal;
use Illuminate\Http\Request;

class AcuerdoController extends Controller
{
    // Método para mostrar la vista de índice con los acuerdos
    public function index()
    {
        $acuerdos = Acuerdo::all();
        return view('acuerdos.index', compact('acuerdos'));
    }

    public function obtenerPresentes(Request $request)
    {
        $id_actas = $request->input('id_Actas');
        $acta = Acta::where('id_Actas', $id_actas)->first();

        if ($acta) {
            //'Presentes' es una cadena de nombres separados por comas
            $presentes = explode(',', $acta->presentes);

            //Limpiar los espacios en blanco alrededor de los nombres
            $presentes = array_map('trim', $presentes);

            return response()->json($presentes);
        } else {
            return response()->json(['success' => false, 'message' => 'Acta no encontrada']);
        }
    }

    // Método para mostrar el formulario de creación
    public function create()
    {
        // Obtén las actas y el personal disponibles en la base de datos
        $actas = Acta::where('estado', 'Abierto')->get();
        $personal = Personal::all();
        $numero_Acuerdo = Acuerdo::count() + 1;
        // Envía las variables a la vista
        return view('acuerdos.create', compact('actas', 'personal', 'numero_Acuerdo'));
    }

    public function destroy(Acuerdo $acuerdo)
    {
        try {
            // Elimina el acuerdo
            $acuerdo->delete();

              // Busca el Acta y actualiza su estado
              $acta = Acta::findOrFail($acuerdo->id_Actas);
              $acta->estado = 'Abierto';
              $acta->save();

            // Lanza un mensaje de éxito
            return redirect()->route('acuerdos.index')->with('success_delete', 'Acuerdo eliminado correctamente.');
        } catch (\Exception $e) {
            // Lanza un mensaje de error
            return redirect()->route('acuerdos.index')->with('error_delete', 'Error al eliminar el acuerdo.');
        }
    }

    public function show($id)
    {
        // Busca el acuerdo por ID (puedes personalizar esta lógica)
        $acuerdo = Acuerdo::findOrFail($id);

        return view('acuerdos.show', compact('acuerdo'));
    }
    public function update(Request $request, Acuerdo $acuerdo)
    {
        try {
            // Validación de campos requeridos
            $request->validate([
                'id_Actas' => 'required|integer', // ID del acta asociado
                'fecha_Acuerdos' => 'required|date', // Fecha del acuerdo
                'motivo_Votacion' => 'required|string', // Motivo de la votación
                'descripcion_Acuerdos' => 'nullable|string', // Descripción del acuerdo, opcional
            ]);

            // Filtrando solo los campos necesarios
            $data = $request->only([
                'id_Actas',
                'id_Personal',
                'fecha_Acuerdos',
                'motivo_Votacion',
                'descripcion_Acuerdos',
            ]);

            // Actualiza el acuerdo con los datos filtrados
            $acuerdo->update($data);

            // Redirige a la lista de acuerdos con un mensaje de éxito
            return redirect()->route('acuerdos.index')->with('success_update', 'Acuerdo actualizado exitosamente.');
        } catch (\Exception $e) {
            // Redirige a la lista de acuerdos con un mensaje de error
            return redirect()->route('acuerdos.index')->with('error_update', 'Hubo un problema al actualizar el acuerdo.');
        }
    }

    public function edit($id)
    {
        // Busca el acuerdo por ID
        $acuerdo = Acuerdo::findOrFail($id);

        // Retorna la vista 'acuerdos.edit' con el acuerdo para editar
        return view('acuerdos.edit', compact('acuerdo'));
    }

    // Método para almacenar un nuevo acuerdo
    public function store(Request $request)
    {
        try {
            // Validación de campos requeridos
            $request->validate([
                'id_Actas' => 'required|integer', // ID del acta asociado, requerido y debe ser un entero
                'id_Personal' => 'nullable|integer', // ID del personal, requerido y debe ser un entero
                'motivo_Votacion' => 'required|string', // Motivo de la votación, requerido y debe ser una cadena
                'fecha_Acuerdos' => 'required|date', // Fecha del acuerdo, requerida y debe ser de tipo fecha
                'descripcion_Acuerdos' => 'required|string', // Descripción del acuerdo, opcional y debe ser una cadena
            ]);

            // Filtra solo los campos necesarios para crear un nuevo acuerdo
            $data = $request->only([
                'id_Personal',
                'id_Actas',
                'fecha_Acuerdos',
                'motivo_Votacion',
                'descripcion_Acuerdos',
            ]);

            // Crea un nuevo acuerdo con los datos proporcionados
            Acuerdo::create($data);

            // Busca el Acta y actualiza su estado
            $acta = Acta::findOrFail($data['id_Actas']);
            $acta->estado = 'Cerrado';
            $acta->save();

            // Redirige a la lista de acuerdos con un mensaje de éxito
            return redirect()->route('acuerdos.index')->with('success_create', 'Acuerdo creado y estado de Acta actualizado exitosamente.');
        } catch (\Exception $e) {
            // Redirige a la lista de acuerdos con un mensaje de error en caso de excepción
            return redirect()->route('acuerdos.index')->with('error_create', 'Hubo un problema al crear el acuerdo: ' . $e->getMessage());
        }
    }
}
