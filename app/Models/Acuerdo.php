<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acuerdo extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'Acuerdos';

    // Clave primaria personalizada
    protected $primaryKey = 'id_Acuerdo';

    // Deshabilitamos timestamps ya que la tabla no los incluye
    public $timestamps = false;

    // Definir los atributos que se pueden asignar masivamente
    protected $fillable = [
        'id_Actas',
        'id_Personal',
        'fecha_Acuerdos',
        'descripcion_Acuerdos',
    ];

    public function acta()
    {
        return $this->belongsTo(Acta::class, 'id_Actas');
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'id_Personal');
    }
}
