<?php

namespace App\Models\Page;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PageCategory extends Model
{
    use HasUuids;
    protected $table = 'page_categories';
    protected $fillable = [
      'title','slug','description','parent_id', 'thumbnail'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->title);
        });
    }
}
