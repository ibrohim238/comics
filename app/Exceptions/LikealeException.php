<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Lang;
use RuntimeException;

class LikealeException extends RuntimeException
{
    public static function exists(): self
    {
        return new self(Lang::get('likeable.unique'));
    }

    public static function notFound(): self
    {
        return new self(Lang::get('likeable.notFound'));
    }
}
