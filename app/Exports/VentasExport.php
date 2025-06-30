<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VentasExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Origen',
            'Departamento',
            'Provincia',
            'Municipio',
            'Dirección',
            'Abonado',
            'Nombres y Apellidos',
            'Tlf. Habitación',
            'Tlf. Móvil',
            'DTH',
            'Cnt. Equipos',
            'Tipo Instalación',
            'Fecha Ingreso',
            'Fecha Age.',
            'Distribuidor Age.',
            'Tipo Cliente-Grupo Afinidad',
            'Origen Abonado',
        ];
    }
}
