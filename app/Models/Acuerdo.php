<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acuerdo extends Model
{
    public function acta()
{
    return $this->belongsTo(Acta::class, 'id_actas');
}

public function personal()
{
    return $this->belongsTo(Personal::class, 'id_personal');
}
}
