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
            $table->text('descripcion')->nullable();
            $table->string('correlativo');
            $table->text('motivo_ausencia');
            $table->text('contenido_elaboracion');
            $table->text('presentes');
            $table->text('ausentes');
            $table->text('tipo_sesion');
            
            $table->foreign('id_Libros')->references('id')->on('libros')->onDelete('cascade');
            $table->foreign('id_Personal')->references('id')->on('personal')->onDelete('cascade');
        });
    }

};

