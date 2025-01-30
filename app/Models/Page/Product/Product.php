<?php

namespace App\Models\Page\Product;

use App\Models\Page\Page;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasUuids;
    protected $table = 'products';
    protected $fillable = [
        'title', 'description', 'slug', 'price', 'page_id', 'thumb'
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
