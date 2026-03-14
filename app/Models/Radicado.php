<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Radicado extends Model
{
    protected $fillable = ['type', 'consecutive'];

    /**
     * Get the next radicado number statically and increment it
     */
    public static function getNextRadicado($type)
    {
        $prefix = $type === 'entrada' ? 'RE' : 'ENV';
        
        $tracker = self::firstOrCreate(
            ['type' => $type],
            ['consecutive' => 0.1]
        );

        $number = $tracker->consecutive;
        $numberStr = (string)$number;
        
        // Increment for next time
        $tracker->consecutive += 1;
        $tracker->save();
        
        // If it's a whole number or ends in .0, str_pad might behave differently
        // but since it's decimal(8,1), it should usually have the .0 if it's an integer.
        // However, user wants 0.1 format.
        
        return $prefix . '-' . str_pad($numberStr, 6, '0', STR_PAD_LEFT);
    }
}
