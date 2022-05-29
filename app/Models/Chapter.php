<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Chapter extends Model implements HasMedia, Eventable, Likeable, Commentable
{
    use HasFactory;
    use InteractsWithMedia;
    use HasEvents;
    use HasLikes;
    use HasComments;

    protected $fillable = [
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
