<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personal;

class PersonalController extends Controller
{
   
    public function index()
    {
        $personales = Personal::all();
        return view('personales.index', compact('personales'));
    }


    public function create()
    {
        return view('personales.create');
    }

  
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
        ]);

        Personal::create($validatedData);

        return redirect()->route('personales.index')->with('success', 'Personal creado exitosamente.');
    }

   
    public function show($id)
    {
        $personal = Personal::findOrFail($id);
        return view('personales.show', compact('personal'));
    }

    public function edit($id)
    {
        $personal = Personal::findOrFail($id);
        return view('personales.edit', compact('personal'));
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
        ]);

        $personal = Personal::findOrFail($id);
        $personal->update($validatedData);

        return redirect()->route('personales.index')->with('success', 'Personal actualizado exitosamente.');
    }

    
    public function destroy($id)
    {
        $personal = Personal::findOrFail($id);
        $personal->delete();

        return redirect()->route('personales.index')->with('success', 'Personal eliminado exitosamente.');
    }
}

