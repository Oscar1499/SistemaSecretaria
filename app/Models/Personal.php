<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'personal';

    // Nombre de la clave primaria
    protected $primaryKey = 'id_Personal';

    public $timestamps = false;

    // Definir los atributos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'apellido',
        'cargo',
        'propietario',
    ];
}
