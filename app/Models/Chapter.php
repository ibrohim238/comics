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

class Chapter extends Model implements Eventable, Commentable
{
    use HasFactory;
    use HasEvents;
    use HasComments;

    protected $fillable = [
        'volume',
        'number',
        'name',
    ];

    public function manga(): BelongsTo
    {
        return $this->belongsTo(Manga::class);
    }

    public function chapterTeams(): HasMany
    {
        return $this->hasMany(ChapterTeam::class);
    }

    public function getRouteKey(): string
    {
        return $this->volume . '-' . $this->number;
    }
}
