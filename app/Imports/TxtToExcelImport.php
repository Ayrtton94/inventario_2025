<?php

namespace App\Imports;

use App\Models\Pendientes;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Auth;

class TxtToExcelImport implements ToModel, WithHeadingRow
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function model(array $row)
{
    $fechaIngreso = $this->convertirFecha($row['fecha_ingreso']);
    $fechaAge = $this->convertirFecha($row['fecha_age']);

    // Definimos la clave única por la cual buscar el pendiente
    $clave = ['abonado' => $row['abonado']];

    // Campos a insertar o actualizar
    $datos = [
        'departamento' => $row['departamento'] ?? null,
        'provincia' => $row['provincia'] ?? null,
        'municipio' => $row['municipio'] ?? null,
        'direccion' => $row['direccion'] ?? null,
        'nombres' => $row['nombres'] ?? null,
        'tlf_habitacion' => $row['tlf_habitacion'] ?? null,
        'tlf_movil' => $row['tlf_movil'] ?? null,
        'dth' => $row['dth'] ?? null,
        'cnt_equipos' => $row['cnt_equipos'] ?? null,
        'tipo_instalacion' => $row['tipo_instalacion'] ?? null,
        'fecha_ingreso' => $fechaIngreso,
        'fecha_age' => $fechaAge,
        'distribuidor_age' => $row['distribuidor_age'] ?? null,
        'tipo_cliente_grupo_afinidad' => $row['tipo_cliente_grupo_afinidad'] ?? null,
        'origen_abonado' => $row['origen_abonado'] ?? null,
        'user_id' => $this->userId,
    ];

    // Usamos updateOrCreate para evitar duplicados
    Pendientes::updateOrCreate($clave, $datos);

    return null; // No devolver una nueva instancia si ya se guarda manualmente
}


    private function convertirFecha($valor)
    {
        if (empty($valor) || !is_numeric($valor)) {
            return null;
        }

        return \Carbon\Carbon::instance(Date::excelToDateTimeObject($valor))->format('Y-m-d');
    }
}
