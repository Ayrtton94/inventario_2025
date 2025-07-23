<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetallePendienteProducto extends Model
{
   use HasFactory;

    protected $fillable = [
        'pendiente_producto_id',        
        'detalle_producto_id'
    ];

    public function pendienteProducto()
    {
        return $this->belongsTo(PendienteProducto::class, 'pendiente_producto_id');
    }

    public function detalleProducto()
    {
        return $this->belongsTo(Detalles_producto::class, 'detalle_producto_id');
    }
}
