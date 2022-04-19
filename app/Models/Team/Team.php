<?php

namespace App\Models\Team;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'team_users',
            'team_id',
            'user_id'
        );
    }

    public function teamable(): MorphTo
    {
        return $this->morphTo();
    }
}
