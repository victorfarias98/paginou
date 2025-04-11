<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Service extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'page_id',
        'title',
        'description',
        'price',
        'duration',
        'status',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
} 