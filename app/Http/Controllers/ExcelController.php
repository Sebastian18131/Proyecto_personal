<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Exports\RadicadosExport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function export(Request $request)
    {
        $filter = $request->query('filter', 'todos');
        $fileName = 'planillas_radicacion_' . $filter . '_' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(new RadicadosExport($filter), $fileName);
    }
}
