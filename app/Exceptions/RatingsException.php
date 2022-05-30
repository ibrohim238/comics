<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Lang;
use RuntimeException;

class RatingsException extends RuntimeException
{
    public static function notFound(string $type): self
    {
        return new self(Lang::get('rateable.notFound', ['type' => $type]));
    }
}
