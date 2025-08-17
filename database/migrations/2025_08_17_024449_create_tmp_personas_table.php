<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tmp_personas', function (Blueprint $table) {
            $table->string('nombre', length: 50);
            $table->string('paterno', length: 50);
            $table->string('materno', length: 50);
            $table->string('calle', length: 100);
            $table->string('numero_exterior', length: 4);
            $table->string('numero_interior', length: 4);
            $table->string('colonia', length: 100);
            $table->string('cp', length: 5);
            $table->bigInteger('telefono');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tmp_personas');
    }
};
