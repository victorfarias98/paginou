<?php

namespace App\Models\Page\Service;

use App\Models\Page\Page;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasUuids;
    protected $table = 'services';
    protected $fillable = [
        'title','description', 'thumb', 'page_id'
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
