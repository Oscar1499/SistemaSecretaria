<?php 

use Illuminate\Database\Eloquent\Model;

class Certificacion extends Model
{
    protected $table = 'certificacion';
    protected $primaryKey = 'id_Certificacion'; 
    public $timestamps = false; 

    protected $fillable = [
       'fecha_Certificacion',
       'contenido_Certificacion',
    ];
}

?>