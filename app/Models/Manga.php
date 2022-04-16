<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Manga extends Model implements HasMedia, Eventable, Rateable
{
    use HasFactory;
    use HasSlug;
    use HasEvents;
    use HasRatings;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
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

    public function getRouteKeyName(): string
    {
        return 'slug';
    }


    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
