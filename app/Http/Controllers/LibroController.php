<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;
use App\Models\Personal;


class LibroController extends Controller
{
    public function index()
    {
        $libros = Libro::all();

        return view('libros.index', compact('libros'));
    }


    public function create()
    {
        return view('libros.create');
    }

    public function store(Request $request)
    {
        try {
            // Guardar libro
            Libro::create($request->all());

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
        return view('libros.edit', compact('libro'));
    }

    public function update(Request $request, Libro $libro)
    {
        $request->validate([
            'anio' => 'required|integer',
            'descripcion_Libro' => 'required|string',
        ]);

        $libro->update($request->all());
        return redirect()->route('libros.index');
    }

    public function destroy(Libro $libro)
    {
        $libro->delete();
        return redirect()->route('libros.index')->with('delete', 'Libro eliminado correctamente.');
    }

    public function libroActual()
    {
        $anioActual = date('Y');
        return Libro::where('anio', $anioActual)->first();
    }
}
