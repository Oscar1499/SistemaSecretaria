<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('actas', function (Blueprint $table) {
            $table->id('id_Actas');
            $table->unsignedBigInteger('id_libros'); 
            $table->unsignedBigInteger('id_Personal'); 
            $table->date('fecha');
            $table->text('descripcion');
            $table->string('tipo_sesion');
            $table->string('correlativo', 255);
            $table->text('motivo_ausencia')->nullable();
            $table->timestamps(); 
    
         
            $table->foreign('id_libros')->references('id')->on('libros')->onDelete('cascade');
           
            $table->foreign('id_Personal')->references('id')->on('personal')->onDelete('cascade');
        });
    }

};

