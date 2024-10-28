<?php

namespace App\Http\Controllers;

use App\Models\Acuerdo;
use App\Models\Acta;
use Illuminate\Http\Request;

class AcuerdoController extends Controller
{
    public function index()
    {
        $acuerdos = Acuerdo::all();
        return view('acuerdos.index', compact('acuerdos'));
    }

    public function create(Acta $acta)
    {
        return view('acuerdos.create', compact('acta'));
    }

    public function store(Request $request, Acta $acta)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'tipo_votacion' => 'required|string', // unanimidad, mayoria_simple, mayoria_calificada
            'votos_a_favor' => 'required|integer',
            'votos_en_contra' => 'nullable|integer',
        ]);

        $acuerdo = new Acuerdo($request->all());
        $acuerdo->acta()->associate($acta);

        // correlativo
        $acuerdo->numero_correlativo = Acuerdo::where('id_actas', $acta->id)->count() + 1;

      
        if ($request->tipo_votacion === 'mayoria_calificada') {
            $acuerdo->votos_a_favor += 1; //voto doble de la alcaldesa
        }

        $acuerdo->save();
        return redirect()->route('actas.show', $acta->id);
    }

    public function show(Acuerdo $acuerdo)
    {
        return view('acuerdos.show', compact('acuerdo'));
    }

    public function edit(Acuerdo $acuerdo)
    {
        return view('acuerdos.edit', compact('acuerdo'));
    }

    public function update(Request $request, Acuerdo $acuerdo)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'tipo_votacion' => 'required|string',
            'votos_a_favor' => 'required|integer',
            'votos_en_contra' => 'nullable|integer',
        ]);

        $acuerdo->update($request->all());
        return redirect()->route('actas.show', $acuerdo->acta->id);
    }

    public function destroy(Acuerdo $acuerdo)
    {
        $acuerdo->delete();
        return redirect()->route('actas.show', $acuerdo->acta->id);
    }
}
