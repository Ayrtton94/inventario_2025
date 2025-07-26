<?php

namespace App\Models\dth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Detalles_productodth extends Model
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
        return $this->belongsTo(Productodth::class, 'producto_id');
    }
}
