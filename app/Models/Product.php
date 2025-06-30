<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'cod_producto',        
        'producto',
        'cantidad'
    ];

    public function detalles()
    {
        return $this->hasMany(Detalles_producto::class, 'producto_id');
    }
}
