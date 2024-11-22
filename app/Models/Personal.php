<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'personal';  public $timestamps = false;

    // Definir los atributos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'apellido',
        'cargo',
        'propietario',
        'rubricas',
    ];

    public function actas()
{
    return $this->belongsToMany(Acta::class, 'acta_personal', 'personal_id', 'acta_id');
}

}
