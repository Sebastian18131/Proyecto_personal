<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'hash',
        'has_stamp',
        'extension',
        'mime_type',
        'size',
        'folder_id',
        'active'
    ];

     public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
