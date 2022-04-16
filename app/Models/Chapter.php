<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'title',
        'order_column',
    ];


    public function getRouteKeyName(): string
    {
        return 'order_column';
    }
}
