<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Filter extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'description',
    ];

    public function mangas(): MorphToMany
    {
        return $this->morphedByMany(Manga::class, 'filterables');
    }
}
