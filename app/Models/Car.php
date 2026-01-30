<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags() : HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
