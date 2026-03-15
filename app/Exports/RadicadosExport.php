<?php

namespace App\Exports;

use App\Models\PQR;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RadicadosExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filter;

    public function __construct($filter = 'todos')
    {
        $this->filter = $filter;
    }

    public function collection()
    {
        $query = PQR::with('dependency');

        if ($this->filter === 'entrada') {
            $query->where('type', 'entrada');
        } elseif ($this->filter === 'salida') {
            $query->where('type', 'salida');
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Consecutivo',
            'Fecha',
            'Número de Gestión',
            'Dependencia',
            'Destinatario',
            'Asunto',
            'Estado'
        ];
    }

    public function map($pqr): array
    {
        return [
            $pqr->radicado,
            $pqr->created_at->format('d/m/Y'),
            $pqr->id, // Assuming ID is the management number
            $pqr->dependency->name ?? 'N/A',
            $pqr->recipient ?? $pqr->sender_name,
            $pqr->affair,
            $pqr->state ? 'Cerrado' : 'Abierto'
        ];
    }
}
