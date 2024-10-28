<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acta extends Model
{
    public function libro()
{
    return $this->belongsTo(Libro::class, 'id_libros');
}

public function acuerdos()
{
    return $this->hasMany(Acuerdo::class, 'id_actas'); 
}

public function definirTipoSesion()
{
    $dia = date('d', strtotime($this->fecha));

    if (in_array($dia, range(1, 5)) || in_array($dia, range(15, 20))) {
        return 'ordinaria';
    } elseif (in_array($dia, range(6, 14)) || in_array($dia, range(21, 30))) {
        return 'extraordinaria';
    }
}
}
