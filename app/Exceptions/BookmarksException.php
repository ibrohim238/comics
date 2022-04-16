<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Lang;
use RuntimeException;

class BookmarksException extends RuntimeException
{
    public static function exists(): self
    {
        return new self(Lang::get('bookmark.unique'));
    }

    public static function notFound(): self
    {
        return new self(Lang::get('bookmark.notFound'));
    }
}
