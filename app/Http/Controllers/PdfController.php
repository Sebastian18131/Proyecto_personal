<?php

namespace App\Http\Controllers;

// Importa la fachada de DOMPDF para generar PDFs
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Radicado;
use Illuminate\Http\Request;

// Controlador encargado de generar el PDF
class PdfController extends Controller
{
    // Método que recibe la petición del frontend y genera el PDF
    public function generate(Request $request)
    {
        try {
            // Obtiene todos los datos enviados desde el formulario React
            // Se convierte en un array asociativo con todos los campos
            $data = $request->all();

            // Set the consecutive explicitly for SALIDA forms
            $data['consecutivo'] = Radicado::getNextRadicado('salida');

            // 🔹 Create a PQR record for this outgoing document for tracking
            \App\Models\PQR::create([
                'radicado' => $data['consecutivo'],
                'type' => 'salida',
                'year' => date('Y'),
                'recipient' => $data['nombres'] ?? null,
                'sender_name' => $data['firma_nombres'] ?? auth()->user()->name ?? 'Sistema',
                'affair' => $data['asunto'] ?? 'Comunicación sin asunto',
                'description' => $data['texto'] ?? '',
                'request_type' => 'Peticion', // Default for tracking
                'state' => true,
                'response_status' => 'responded',
                'user_id' => auth()->id(),
                'dependency_id' => auth()->user()->dependency_id ?? null,
            ]);

            // Carga la vista 'pdf.template' (Blade) y le pasa la variable $data
            // Esta vista será convertida en un archivo PDF por DOMPDF
            $pdf = Pdf::loadView('pdf.template', ['data' => $data]);

            // Retorna el PDF descargable con el nombre ajustado
            $filename = $data['consecutivo'] . '.pdf';
            return $pdf->download($filename);

        } catch (\Exception $e) {
            // Si ocurre algún error (por ejemplo, la vista no existe)
            // responde con un JSON de error y código HTTP 500
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
