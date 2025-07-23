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
        Schema::create('detalle_pendiente_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendiente_producto_id');
            $table->foreign('pendiente_producto_id')->references('id')->on('pendiente_productos');
            $table->unsignedBigInteger('detalle_producto_id');
            $table->foreign('detalle_producto_id')->references('id')->on('detalles_productos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_pendiente_productos');
    }
};
