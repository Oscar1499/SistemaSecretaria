<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    /**
     * Muestra una lista del recurso.
     */
    public function index()
    {
        $personal = Personal::get();
        $propietarios = Personal::where('propietario', 1)->get(); // Solo los que son propietarios
        return view('personal.index', compact('personal', 'propietarios'));
    }


    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        return view('personal.create');
    }

    /**
     * Almacena un nuevo recurso en la base de datos.
     */
    public function store(Request $request)
    {
        // Convertimos el valor de 'propietario' en un booleano según el estado del checkbox
        $request->merge(['propietario' => $request->has('propietario')]);

        // Validación de los datos
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cargo' => 'nullable|string|max:100',
            'propietario' => 'required|boolean',
            'rubricas' => 'required|string|max:100', // Ajusta el tipo de validación según tus necesidades
        ]);

        // Crear el nuevo registro en la base de datos
        Personal::create($request->all());

        // Redireccionar con mensaje de éxito
        return redirect()->route('personal.index')->with('success', 'Personal creado exitosamente.');
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show($id)
    {
        $personal = Personal::findOrFail($id);
        return view('personal.show', compact('personal'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit($id)
    {
        $personal = Personal::findOrFail($id);
        return view('personal.edit', compact('personal'));
    }

    /**
     * Actualiza el recurso especificado en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cargo' => 'nullable|string|max:100',
            'propietario' => 'required|boolean',
        ]);

        $personal = Personal::findOrFail($id);
        $personal->update($request->all());
        return redirect()->route('personal.index')->with('success', 'Personal actualizado exitosamente.');
    }

    /**
     * Elimina el recurso especificado de la base de datos.
     */
    public function destroy($id)
    {
        $personal = Personal::findOrFail($id);
        $personal->delete();
        return redirect()->route('personal.index')->with('delete', 'Personal eliminado exitosamente.');
    }
}
