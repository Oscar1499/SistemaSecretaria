<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Personal;
use Illuminate\Http\Request;

class LibroController extends Controller
{

    public function index()
    {
        $libros = Libro::all();
        return view('libros.index', compact('libros'));
    }

    public function create()
    {
        $alcalde = Personal::where('cargo', 'Alcaldesa')->get();
        $sindico = Personal::where('cargo', 'Sindico')->get();
        return view('libros.create', compact('alcalde', 'sindico'));
    }

    public function store(Request $request)
    {
        try {

            // Validación de campos requeridos
            $request->validate([
                'fechainicio_Libro' => 'required|date',
                'fechafinal_Libro' => 'required|date',
                'descripcion_Libro' => 'required|string',
                'apertura_Libro' => 'required|string',
            ]);

            // Filtrando solo los campos necesarios para el modelo Libro
            $data = $request->only([
                'fechainicio_Libro',
                'fechafinal_Libro',
                'descripcion_Libro',
                'apertura_Libro',
            ]);

            Libro::create($data);

            return redirect()->route('libros.create')->with('success', 'Libro agregado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('libros.create')->with('error', 'Hubo un problema al agregar el libro.');
        }
    }

    public function show(Libro $libro)
    {
        $actas = $libro->actas; // actas asociadas
        return view('libros.show', compact('libro', 'actas'));
    }

    public function edit(Libro $libro)
    {
        $alcalde = Personal::where('cargo', 'Alcaldesa')->get();
        $sindico = Personal::where('cargo', 'Sindico')->get();
        return view('libros.edit', compact('libro', 'sindico', 'alcalde'));
    }

    public function update(Request $request, Libro $libro)
    {
        try {

            // Validación de campos requeridos
            $request->validate([
                'fechainicio_Libro' => 'required|date',
                'fechafinal_Libro' => 'required|date',
                'descripcion_Libro' => 'required|string',
                'apertura_Libro' => 'required|string',
            ]);

            // Filtrando solo los campos necesarios para el modelo Libro
            $data = $request->only([
                'fechainicio_Libro',
                'fechafinal_Libro',
                'descripcion_Libro',
                'apertura_Libro',
            ]);
            $libro->update($data);

            return redirect()->route('libros.index')->with('success_Libro', 'Libro actualizado correctamente.');
        } catch (\Exception $e) {

            return redirect()->route('libros.index')->with('error_Libro', 'Hubo un problema al actualizar el libro.');
        }
    }

    public function destroy(Libro $libro)
    {
        try {
            $libro->delete();
            return redirect()->route('libros.index')->with('delete', 'Libro eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('libros.index')->with('error_delete', 'Error al eliminar el libro.');
        }
    }

    // public function libroActual()
    // {
    //     $anioActual = date('Y');
    //     return Libro::where('anio', $anioActual)->first();
    // }
}
