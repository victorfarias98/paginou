<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'original_filename',
        'mime_type',
        'size',
        'path',
        'type', // 'image', 'video', 'document'
        'mediable_type',
        'mediable_id',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
} 