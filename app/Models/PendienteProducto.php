<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendienteProducto extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',        
        'producto_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function producto()
    {
        return $this->belongsTo(Product::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetallePendienteProducto::class);
    }
}
// End of file
// This file defines the PendienteProducto model, which represents the relationship between a pending task and