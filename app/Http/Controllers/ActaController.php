<?php

namespace App\Http\Controllers;

use App\Models\Acta;
use App\Models\Libro;
use App\Models\Personal;
use Illuminate\Http\Request;

class ActaController extends Controller
{
    public function index()
    {
        $actas = Acta::all();
        $acta_estado = Acta::where('estado')->get();
        return view('actas.index', compact('actas', 'acta_estado'));
    }

    public function create()
    {
        $alcaldesa = Personal::where('cargo', 'Alcaldesa')->first();
        // Contar el número de actas en la base de datos para determinar el correlativo de la acta a editar
        $numero_Actas = Acta::count() + 1;
        $secretario = Personal::where('cargo', 'Secretario')->first();
        $personal = Personal::all();
        $libros  = Libro::where('estado', 'Abierto')->get();
        return view('actas.create', compact( 'alcaldesa', 'secretario', 'personal', 'numero_Actas', 'libros'));
    }
    public function store(Request $request)
    {
        try {
            // Validar los campos requeridos
            $request->validate([
                'fecha' => 'required|date',
                // 'id_Personal' => 'nullable|string',
                'id_libros' => 'required|integer',
                'estado' => 'required|string',
                'contenido_elaboracion' => 'required|string',
                'presentes' => 'required|string',
                'ausentes' => 'required|string',
                'descripcion' => 'required|string',
                'tipo_sesion' => 'required|string',
                'correlativo' => 'required|string',
                'motivo_ausencia' => 'nullable|string',
            ]);

            // Crear una nueva instancia de Acta con los datos proporcionados
            $acta = new Acta();
            // Asignar el ID del libro asociado a la acta
            $acta->id_libros = $request->id_libros;
            // Asignar el estado de la acta
            $acta->estado = $request->estado;
            // Asignar la fecha de la acta
            $acta->fecha = $request->fecha;
            // Asignar el correlativo de la acta
            $acta->correlativo = $request->correlativo;
            // Asignar el motivo de ausencia, si no se proporciona, usar 'Ninguno' como valor predeterminado
            $acta->motivo_ausencia = $request->motivo_ausencia ?? 'Ninguno';
            // Asignar el contenido de elaboración de la acta
            $acta->contenido_elaboracion = $request->contenido_elaboracion;
            // Asignar la lista de personas presentes en la acta
            $acta->presentes = $request->presentes;
            // Asignar la lista de personas ausentes en la acta
            $acta->ausentes = $request->ausentes;
            // Asignar el tipo de sesión de la acta
            $acta->tipo_sesion = $request->tipo_sesion;
            // Asignar la descripción de la acta
            $acta->descripcion = $request->descripcion;

            // Guardar en la base de datos
            $acta->save();
            // Busca el Acta y actualiza su estado
            $libros = Libro::findOrFail($request->id_libros);
            $libros->estado = 'Cerrado';
            $libros->save();

          
            // Redireccionar con mensaje de éxito
            return redirect()->route('actas.index')->with('success_create', 'Acta creada exitosamente.');
        } catch (\Exception $e) {
            // Redireccionar un mensaje de error
            return redirect()->route('actas.index')->with('error_create', 'Error al crear un acta.');
        }
    }

    public function show(Acta $acta)
    {
        $acuerdos = $acta->acuerdos;
        return view('actas.show', compact('acta', 'acuerdos'));
    }

    public function edit(Acta $acta)
    {
        $libros_cerrados  = Libro::where('estado', 'Cerrado')->get();
        $personal = Personal::all();
        $alcaldesa = Personal::where('cargo', 'Alcaldesa')->first();
        $secretario = Personal::where('cargo', 'Secretario')->first();
        $libros = Libro::all();
        return view('actas.edit', compact('acta', 'libros', 'alcaldesa', 'secretario', 'personal', 'libros_cerrados'));
    }

    public function update(Request $request, Acta $acta)
    {
        try {
            // Validar los campos requeridos
            $request->validate([
                'fecha' => 'required|date',
                // 'id_Personal' => 'required|integer',
                'contenido_elaboracion' => 'required|string',
                'presentes' => 'required|string',
                'ausentes' => 'required|string',
                'descripcion' => 'required|string',
                'tipo_sesion' => 'required|string',
                'correlativo' => 'required|string',
                'motivo_ausencia' => 'nullable|string',
            ]);
            $data = $request->only([
                'fecha',
                // 'id_Personal',
                'contenido_elaboracion',
                'presentes',
                'ausentes',
                'descripcion',
                'tipo_sesion',
                'motivo_ausencia',
            ]);
            $acta->update($data);

            return redirect()->route('actas.index')->with('success_update', 'Acta actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('actas.index')->with('error_update', 'Error al actualizar la acta.');
        }
    }

    public function destroy(Acta $acta)
    {
        // Función para eliminar una acta
        try {

            $acta->delete();
            // Busca el Acta y actualiza su estado
            $libros = Libro::findOrFail($acta->id_libros);
            $libros->estado = 'Abierto';
            $libros->save();
            return redirect()->route('actas.index')->with('success_delete', 'Acta eliminada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->route('actas.index')->with('error_delete', 'Error al eliminar la acta.');
        }
    }
}
