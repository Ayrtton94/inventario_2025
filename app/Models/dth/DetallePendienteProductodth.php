<?php

namespace App\Models\dth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetallePendienteProductodth extends Model
{
   use HasFactory;
   use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'pendiente_producto_id',        
        'detalle_producto_id'
    ];

    public function pendienteProducto()
    {
        return $this->belongsTo(PendienteProductodth::class, 'pendiente_producto_id');
    }

    public function detalleProducto()
    {
        return $this->belongsTo(Detalles_productodth::class, 'detalle_producto_id');
    }
}
