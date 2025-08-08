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
        Schema::create('technical_formdths', function (Blueprint $table) {
              $table->id();
            $table->string('abonado');
            $table->string('fecha_ingreso');
            $table->unsignedBigInteger('pendientedths_id');
            $table->foreign('pendientedths_id')->references('id')->on('pendientedths');
            $table->string('nombre');
            $table->string('direccion');
            $table->string('comuna');
            $table->string('ciudad');
            $table->string('rut');
            $table->string('fono');
            $table->string('celular');
            $table->string('google_maps_link');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('rut_tecnico'); // corregido
            $table->string('name_tecnico');
            $table->string('empresa')->nullable();
            $table->boolean('servis_1')->default(false);
            $table->boolean('servis_2')->default(false);
            $table->boolean('servis_3')->default(false);
            $table->boolean('servis_4')->default(false);
            $table->boolean('servis_5')->default(false);
            $table->boolean('servis_6')->default(false);
            $table->boolean('servis_7')->default(false);
            $table->string('servis_detalle')->nullable();
            $table->string('settopbox1')->nullable();
            $table->string('settopbox2')->nullable();
            $table->string('settopbox3')->nullable();
            $table->string('settopbox4')->nullable();
            $table->string('smartcard1')->nullable();
            $table->string('smartcard2')->nullable();
            $table->string('smartcard3')->nullable();
            $table->string('smartcard4')->nullable();
            $table->string('antena')->nullable();
            $table->string('lnb')->nullable();
            $table->string('cable')->nullable();
            $table->string('conectores')->nullable();
            $table->string('spliter')->nullable();
            $table->string('grampas')->nullable();
            $table->string('pasamuros')->nullable();
            $table->string('hdmi')->nullable();
            $table->string('rca')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technical_formdths');
    }
};
