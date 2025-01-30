<?php

namespace App\Models\Page;

use App\Models\Page\Product\Product;
use App\Models\Page\Service\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasUuids;

    protected $table = 'pages';
    protected $fillable = [
        'title','slug','content','thumb', 'user_id', 'category_id'
    ];
    protected $hidden = [];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Pagecategory::class, 'category_id');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->title);
        });
    }
}
