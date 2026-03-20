<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    protected $fillable = [
        'user_id',
        'license_plate',
        'make',
        'model',
        'price',
        'mileage',
        'seats',
        'doors',
        'production_year',
        'weight',
        'color',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags() : HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
