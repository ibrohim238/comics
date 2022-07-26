<?php

namespace App\Models;

use App\Enums\RateTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Rate extends Model
{
    protected $fillable = [
        'value',
        'type',
        'user_id',
        'rateable_id',
        'rateable_type',
    ];

    protected $casts = [
        'type' => RateTypeEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rateable(): MorphTo
    {
        return $this->morphTo();
    }
}
