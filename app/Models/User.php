<?php

namespace App\Models;

use App\Models\Team\Team;
use App\Models\Team\TeamTrait;
use App\Models\Team\TeamUser;
use App\Versions\V1\Dto\FallbackMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use InteractsWithMedia;
    use TeamTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(
            Manga::class,
            'bookmarks',
            'user_id',
            'manga_id'
        );
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->singleFile()
            ->useFallbackUrl(url('/media/avatar.png'));
    }

    public function getFirstMedia(string $collectionName = 'default', $filters = [])
    {
        $media = $this->getMedia($collectionName, $filters);

        return $media->first() ?? new FallbackMedia($collectionName, $this->getFallbackMediaUrl($collectionName));
    }
}
