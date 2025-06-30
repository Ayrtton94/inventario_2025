<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Detalles_producto extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'producto_id',
        'fecha_ingreso',
        'stb',
        'cod_art',
        'estado'
    ];

     public function producto()
    {
        return $this->belongsTo(Product::class);
    }
}
