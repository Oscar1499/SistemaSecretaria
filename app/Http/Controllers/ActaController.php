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

        // Aqui elimine las variables de libros y libroActual para que no se muestren en la vista
        return view('actas.create', compact( 'alcaldesa', 'secretario', 'personal', 'numero_Actas'));
    }
    public function store(Request $request)
    {
        try {
            // Validar los campos requeridos
            $request->validate([
                'fecha' => 'required|date',
                // 'id_Personal' => 'nullable|string',
                'estado' => 'nullable|string',
                'contenido_elaboracion' => 'required|string',
                'presentes' => 'required|string',
                'ausentes' => 'required|string',
                'descripcion' => 'required|string',
                'tipo_sesion' => 'required|string',
                'correlativo' => 'required|string',
                'motivo_ausencia' => 'nullable|string',
            ]);

            // Crear una nueva instancia de Acta
            $acta = new Acta();
            $acta->id_libros = 7;
            $acta->estado = $request->estado;
            // $acta->id_Personal = $request->id_Personal;
            $acta->fecha = $request->fecha;
            $acta->correlativo = $request->correlativo;
            $acta->motivo_ausencia = $request->motivo_ausencia ?? 'Ninguno'; // Valor predeterminado si no se proporciona
            $acta->contenido_elaboracion = $request->contenido_elaboracion;
            $acta->presentes = $request->presentes;
            $acta->ausentes = $request->ausentes;
            $acta->tipo_sesion = $request->tipo_sesion;
            $acta->descripcion = $request->descripcion;

            // Guardar en la base de datos
            $acta->save();

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
        $personal = Personal::all();
        $alcaldesa = Personal::where('cargo', 'Alcaldesa')->first();
        $secretario = Personal::where('cargo', 'Secretario')->first();
        $libros = Libro::all();
        return view('actas.edit', compact('acta', 'libros', 'alcaldesa', 'secretario', 'personal'));
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
            return redirect()->route('actas.index')->with('success_delete', 'Acta eliminada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->route('actas.index')->with('error_delete', 'Error al eliminar la acta.');
        }
    }
}
