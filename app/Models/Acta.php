<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acta extends Model
{
    protected $table = 'Actas';

    protected $primaryKey = 'id_Actas';

    protected $fillable = [
        'id_libros',
        // 'id_Personal',
        'estado',
        'fecha',
        'contenido_elaboracion',
        'presentes',
        'ausentes',
        'descripcion',
        'tipo_sesion',
        'correlativo',
        'motivo_ausencia',
    ];

    public function personalAusente()
    {
        return $this->belongsToMany(Personal::class, 'acta_personal', 'acta_id', 'personal_id')
            ->withPivot('motivo_ausencia')
            ->withTimestamps();
    }

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
        return $this->belongsTo(Personal::class, 'acta_personal', 'acta_id', 'personal_id');
    }
}
