<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
   
public function actas()
{
    return $this->hasMany(Acta::class, 'id_libros'); 
}

}
