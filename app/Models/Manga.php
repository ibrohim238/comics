<?php

namespace App\Models;

use App\Enums\RateTypeEnum;
use App\Interfaces\Bookmarkable;
use App\Interfaces\Commentable;
use App\Interfaces\Eventable;
use App\Interfaces\Rateable;
use App\Interfaces\Ratingable;
use App\Interfaces\Teamable;
use App\Traits\HasBookmarks;
use App\Traits\HasComments;
use App\Traits\HasEvents;
use App\Traits\HasRates;
use App\Traits\HasRatings;
use App\Traits\HasTeams;
use IAleroy\Tags\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use IAleroy\Tags\HasTags;

class Manga extends Model
    implements
    HasMedia,
    Eventable,
    Commentable,
    Teamable,
    Taggable,
    Rateable,
    Ratingable,
    Bookmarkable
{
    use HasFactory;
    use HasSlug;
    use HasEvents;
    use HasComments;
    use InteractsWithMedia;
    use HasTeams;
    use HasTags;
    use HasRates;
    use HasRatings;
    use HasBookmarks;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'published_at',
    ];

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function chapterVotes(): HasManyThrough
    {
        return $this->hasManyThrough(Rate::class, Chapter::class, 'manga_id', 'rateable_id')
            ->where('rateable_type', getMorphedType(Chapter::class))
            ->where('type', RateTypeEnum::VOTE_TYPE->value);
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
}
