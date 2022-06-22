<?php

namespace App\Models;

use App\Enums\RatesTypeEnum;
use App\Interfaces\Commentable;
use App\Interfaces\Eventable;
use App\Interfaces\Filterable;
use App\Interfaces\Rateable;
use App\Interfaces\Ratingable;
use App\Interfaces\Teamable;
use App\Traits\HasComments;
use App\Traits\HasRates;
use App\Traits\HasEvents;
use App\Traits\HasFilters;
use App\Traits\HasRatings;
use App\Traits\HasTeams;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Manga extends Model implements HasMedia, Eventable, Commentable, Teamable, Filterable, Rateable, Ratingable
{
    use HasFactory;
    use HasSlug;
    use HasEvents;
    use HasComments;
    use InteractsWithMedia;
    use HasTeams;
    use HasFilters;
    use HasRates;
    use HasRatings;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'published_at',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'bookmarks',
            'manga_id',
            'user_id');
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->singleFile();
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function chapterVotes(): HasManyThrough
    {
        return $this->hasManyThrough(Rate::class, Chapter::class, 'manga_id', 'rateable_id')
            ->where('rateable_type', getMorphedType(Chapter::class))
            ->where('type', RatesTypeEnum::VOTE_TYPE->value);
    }
}
