<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Pendientedth extends Model
{
   use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id',
        'departamento',
        'provincia',
        'municipio',
        'direccion',
        'abonado',
        'nombres',
        'tlf_habitacion',
        'tlf_movil',
        'dth',
        'cnt_equipos',
        'tipo_instalacion',
        'fecha_ingreso',
        'fecha_age',
        'distribuidor_age',
        'tipo_cliente_grupo_afinidad',
        'origen_abonado'
    ];
    
    public function user()
        {
            return $this->belongsTo(User::class);
        }
}
