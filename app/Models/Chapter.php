<?php

namespace App\Models;

use App\Interfaces\Commentable;
use App\Interfaces\Eventable;
use App\Interfaces\Rateable;
use App\Interfaces\Votable;
use App\Traits\HasComments;
use App\Traits\HasRates;
use App\Traits\HasEvents;
use App\Traits\HasVotes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Chapter extends Model implements Eventable, Commentable,HasMedia,Rateable, Votable
{
    use HasFactory;
    use HasComments;
    use InteractsWithMedia;
    use HasEvents;
    use HasRates;
    use HasVotes;

    protected $fillable = [
        'volume',
        'number',
        'name',
        'free_at'
    ];

    protected $casts = [
        'free_at' => 'datetime'
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
