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
        Schema::create('detalles_productos', function (Blueprint $table) {
           $table->id();
            $table->foreignId('producto_id')->constrained('products')->onDelete('cascade'); // Clave foránea
            $table->string('fecha_ingreso');
            $table->string('stb');
            $table->string('cod_art'); // Este campo también puede ser usado para relacionar al momento de importar
            $table->string('estado');
            $table->softDeletes();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_productos');
    }
};
