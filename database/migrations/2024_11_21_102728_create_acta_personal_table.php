<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acta_personal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('acta_id');
            $table->unsignedBigInteger('personal_id'); 
            $table->timestamps();

           
            $table->foreign('acta_id')->references('id')->on('actas')->onDelete('cascade');
            $table->foreign('personal_id')->references('id')->on('personal')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acta_personal');
    }
};

