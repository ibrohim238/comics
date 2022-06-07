<?php

namespace App\Models;

use App\Enums\RatesTypeEnum;
use App\Interfaces\Commentable;
use App\Interfaces\Eventable;
use App\Interfaces\Rateable;
use App\Interfaces\Votable;
use App\Traits\HasComments;
use App\Traits\HasRates;
use App\Traits\HasEvents;
use App\Traits\HasVotes;
use App\Versions\V1\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Chapter extends Model implements HasMedia, Eventable, Commentable, Rateable, Votable
{
    use HasFactory;
    use InteractsWithMedia;
    use HasEvents;
    use HasComments;
    use Sortable;
    use HasRates;
    use HasVotes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        static::$orderType = 'manga_id';
    }

    protected $fillable = [
        'order',
        'volume',
        'number',
        'name',
        'is_paid',
    ];

    protected $casts = [
        'is_paid' => 'bool',
    ];

    public function manga(): BelongsTo
    {
        return $this->belongsTo(Manga::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
