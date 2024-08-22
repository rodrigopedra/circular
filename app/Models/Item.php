<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use PreventsCircularRecursion;

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
