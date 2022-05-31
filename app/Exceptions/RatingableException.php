<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Lang;
use RuntimeException;

class RatingableException extends RuntimeException
{
    public static function notFound(): self
    {
        return new self(Lang::get('ratingable.notFound'));
    }
}
