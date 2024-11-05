<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acta extends Model
{
    protected $table = 'actas'; 

    protected $primaryKey = 'id_Actas'; 

    protected $fillable = [
        'id_libros', 
        'id_Personal',
        'fecha', 
        'descripcion' 
    ];

   
    public function libro()
    {
        return $this->belongsTo(Libro::class, 'id_libros');
    }

   
    public function acuerdos()
    {
        return $this->hasMany(Acuerdo::class, 'id_actas'); 
    }
    public function personal()
    {
        return $this->belongsToMany(personal::class, 'acta_personal', 'acta_id', 'personal_id');
    }
            
        public function definirTipoSesion()
    {
        $dia = $this->fecha->day; 

        
        if (($dia >= 1 && $dia <= 5) || ($dia >= 15 && $dia <= 20)) {
            return 'Ordinaria';
        } else {
            return 'Extraordinaria';
        }
    }

}



