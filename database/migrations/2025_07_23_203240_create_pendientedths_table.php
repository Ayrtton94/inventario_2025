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
        Schema::create('pendientedths', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('departamento')->nullable();
            $table->string('provincia')->nullable();
            $table->string('municipio')->nullable();
            $table->string('direccion')->nullable();
            $table->string('abonado')->nullable();
            $table->string('nombres')->nullable();
            $table->string('tlf_habitacion')->nullable();
            $table->string('tlf_movil')->nullable();
            $table->string('dth')->nullable();
            $table->string('cnt_equipos')->nullable();
            $table->string('tipo_instalacion')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->string('fecha_age')->nullable();
            $table->string('distribuidor_age')->nullable();
            $table->string('tipo_cliente_grupo_afinidad')->nullable();
            $table->string('origen_abonado')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendientedths');
    }
};
