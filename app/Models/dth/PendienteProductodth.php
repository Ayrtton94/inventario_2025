<?php

namespace App\Models\dth;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendienteProductodth extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

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
        return $this->belongsTo(Productodth::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetallePendienteProductodth::class, 'pendiente_producto_id');
    }
}
