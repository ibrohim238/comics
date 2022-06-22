<?php

namespace App\Models;

use App\Interfaces\Likeable;
use App\Interfaces\Rateable;
use App\Traits\HasLikes;
use App\Traits\HasRates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model implements Rateable, Likeable
{
    use SoftDeletes;
    use HasFactory;
    use HasRates;
    use HasLikes;

    protected $fillable = [
        'user_id',
        'parent_id',
        'content',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
