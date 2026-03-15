<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Radicado extends Model
{
    protected $fillable = ['type', 'consecutive'];

    /**
     * Get the next radicado number statically and increment it
     * Following nomenclature: {Ficha}-{Type}-{Consecutive}-{DependencyCode}
     * Example: 6001-ENV-120-2.10
     */
    public static function getNextRadicado($type, $fichaNumber = '6000', $dependencyCode = '1.0')
    {
        // Use REC for Recibido (entrada) and ENV for Enviado (salida)
        $prefix = $type === 'entrada' ? 'REC' : 'ENV';
        
        $tracker = self::firstOrCreate(
            ['type' => $type],
            ['consecutive' => 1]
        );

        $number = $tracker->consecutive;
        
        // Increment for next time
        $tracker->increment('consecutive');
        
        // Format: {Ficha}-{Type}-{Consecutive}-{DependencyCode}
        // str_pad for consecutive to be at least 3 digits as requested (001)
        return sprintf("%s-%s-%03d-%s", 
            $fichaNumber, 
            $prefix, 
            $number, 
            $dependencyCode
        );
    }
}
