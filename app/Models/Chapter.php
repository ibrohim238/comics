<?php

namespace App\Models;

use App\Models\Team\HasTeams;
use App\Models\Team\Teamable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Chapter extends Model implements HasMedia, Eventable, Likeable, Commentable, Teamable
{
    use HasFactory;
    use InteractsWithMedia;
    use HasEvents;
    use HasLikes;
    use HasComments;
    use HasTeams;

    protected $fillable = [
        'volume',
        'number',
        'title',
        'order_column',
    ];

    public function manga(): BelongsTo
    {
        return $this->belongsTo(Manga::class);
    }


    public function getRouteKeyName(): string
    {
        return 'order_column';
    }
}
