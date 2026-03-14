<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Radicado;
use Illuminate\Http\JsonResponse;

class RadicadoController extends Controller
{
    public function getNext(Request $request): JsonResponse
    {
        $type = $request->query('type', 'entrada'); // 'entrada' or 'salida'
        
        // Use a transaction and lock for update to prevent race conditions if actually modifying
        // For just viewing the *next* possible without saving, we can just read.
        // Wait, the requirement might just be to preview it or actually consume it.
        // If it's preview, we shouldn't increment. So let's add a preview method.
        
        $tracker = Radicado::firstOrCreate(
            ['type' => $type],
            ['consecutive' => 1]
        );
        
        $prefix = $type === 'entrada' ? 'RE' : 'ENV';
        $number = $tracker->consecutive;
        $formatted = $prefix . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);

        return response()->json([
            'consecutive' => $formatted
        ]);
    }
}
