<?php

namespace App\Models;

use App\Interfaces\Eventable;
use App\Interfaces\Rateable;
use App\Interfaces\Votable;
use App\Traits\HasEvents;
use App\Traits\HasRates;
use App\Traits\HasVotes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ChapterTeam extends Model implements HasMedia, Eventable,Rateable, Votable
{
    use HasFactory;
    use InteractsWithMedia;
    use HasEvents;
    use HasRates;
    use HasVotes;

    protected $fillable = [
        'free_at',
        'team_id',
        'chapter_id',
    ];

    protected $casts = [
        'free_at' => 'datetime'
    ];

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
