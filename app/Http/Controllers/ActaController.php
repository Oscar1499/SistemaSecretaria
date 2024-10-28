<?php

namespace App\Http\Controllers;

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

    public function create(Libro $libro)
    {
        return view('actas.create', compact('libro'));
    }

    public function store(Request $request, Libro $libro)
    {
        $request->validate([
            'fecha' => 'required|date',
            'descripcion' => 'required|string',
        ]);

        $acta = new Acta($request->all());
        $acta->libro()->associate($libro);

        // tipo de sesion
        $dia = date('d', strtotime($request->fecha));
        if (in_array($dia, range(1, 5)) || in_array($dia, range(15, 20))) {
            $acta->tipo_sesion = 'ordinaria';
        } else {
            $acta->tipo_sesion = 'extraordinaria';
        }

        $acta->save();
        return redirect()->route('libros.show', $libro->id);
    }

    public function show(Acta $acta)
    {
        $acuerdos = $acta->acuerdos; // aca manda a llamar los acuerdos de las actas
        return view('actas.show', compact('acta', 'acuerdos'));
    }

    public function edit(Acta $acta)
    {
        return view('actas.edit', compact('acta'));
    }

    public function update(Request $request, Acta $acta)
    {
        $request->validate([
            'fecha' => 'required|date',
            'descripcion' => 'required|string',
        ]);

        $acta->update($request->all());
        return redirect()->route('actas.show', $acta->id);
    }

    public function destroy(Acta $acta)
    {
        $acta->delete();
        return redirect()->route('libros.index');
    }
}
