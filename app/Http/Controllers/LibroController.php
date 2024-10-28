<?php

namespace App\Http\Controllers;

use App\Models\Libro;
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
        return view('libros.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'anio' => 'required|integer',
            'descripcion' => 'required|string',
        ]);

        Libro::create($request->all());
        return redirect()->route('libros.index');
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
            'descripcion' => 'required|string',
        ]);

        $libro->update($request->all());
        return redirect()->route('libros.index');
    }

    public function destroy(Libro $libro)
    {
        $libro->delete();
        return redirect()->route('libros.index');
    }
}

