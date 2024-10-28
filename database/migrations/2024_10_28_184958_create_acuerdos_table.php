<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('acuerdos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('acta_id')->constrained()->onDelete('cascade');
            $table->foreignId('personal_id')->constrained()->onDelete('cascade');
            $table->date('fecha_acuerdo');
            $table->text('descripcion_acuerdo')->nullable();
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acuerdos');
    }
};
