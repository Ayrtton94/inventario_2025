<?php

namespace App\Models\dth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class Productodth extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'productodths';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'cod_producto',        
        'producto',
        'cantidad'
    ];

     public function detallesdth()
    {
        return $this->hasMany(Detalles_productodth::class, 'producto_id');
    }
}
