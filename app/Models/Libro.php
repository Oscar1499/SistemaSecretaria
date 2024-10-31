<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $table = 'libros';
    protected $primaryKey = 'id_Libros'; 
    public $timestamps = false; 

    protected $fillable = [
        'anio',
        'descripcion_Libro',
    ];

    public function actas()
    {
        return $this->hasMany(Acta::class, 'id_Libros'); 
    }
}
