<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    public function acuerdos()
{
    return $this->hasMany(Acuerdo::class, 'id_personal'); // campo de relación en Acuerdo
}
}
