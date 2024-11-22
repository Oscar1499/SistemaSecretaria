<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Acta;
use App\Models\Acuerdo;
use App\Models\Personal;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
     
        $totalLibros = Libro::count(); 
        $totalActas = Acta::count(); 
        $totalAcuerdos = Acuerdo::count(); 
        $totalPersonal = Personal::count(); 

       
        $librosLabels = Libro::selectRaw('YEAR(created_at) as year')->distinct()->pluck('year');
        $librosData = Libro::selectRaw('YEAR(created_at) as year, COUNT(*) as total')
                            ->groupBy('year')
                            ->pluck('total');

        $acuerdosLabels = Acuerdo::selectRaw('YEAR(fecha_Acuerdos) as year')->distinct()->pluck('year');
        $acuerdosData = Acuerdo::selectRaw('YEAR(fecha_Acuerdos) as year, COUNT(*) as total')
                               ->groupBy('year')
                               ->pluck('total');

        
        return view('home', compact(
            'totalLibros', 'totalActas', 'totalAcuerdos', 'totalPersonal',
            'librosLabels', 'librosData', 'acuerdosLabels', 'acuerdosData'
        ));
    }
}
