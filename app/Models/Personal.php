<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'personal';
<<<<<<< HEAD
=======

>>>>>>> refs/remotes/origin/master


    public $timestamps = false;

    // Definir los atributos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'apellido',
        'cargo',
        'propietario',
        'rubricas',
    ];
}
