<?php

namespace App\Models\dth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TechnicalFormdth extends Model
{
        use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
       'abonado',
        'fecha_ingreso',
        'pendientedths_id',
        'nombre',
        'direccion',
        'comuna',
        'ciudad',
        'rut',
        'fono',
        'celular',
        'google_maps_link',
        'user_id',
        'rut_tecnico',
        'name_tecnico',
        'empresa',
        'servis_1',
        'servis_2',
        'servis_3',
        'servis_4',
        'servis_5',
        'servis_6',
        'servis_7',
        'servis_detalle',
        'settopbox1',
        'settopbox2',
        'settopbox3',
        'settopbox4',
        'smartcard1',
        'smartcard2',
        'smartcard3',
        'smartcard4',
        'antena',
        'lnb',
        'cable',
        'conectores',
        'spliter',
        'grampas',
        'pasamuros',
        'hdmi',
        'rca'
    ];
}
