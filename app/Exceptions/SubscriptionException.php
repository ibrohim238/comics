<?php

namespace App\Exceptions;

use Exception;

class SubscriptionException extends Exception
{
    public const ACTIVATED_MESSAGE = 'Купон активирован!';
    public const USER_LIMIT_MESSAGE = 'Лимит использования купона "пользователем" исчерпан!';
    public const ENDS_AT_MESSAGE = 'Время использования купона прошло!';
    public const LIMIT_MESSAGE = 'Лимит использования купона исчерпан!';
    public const NOT_FOUND_MESSAGE = 'Купон не существует!';

    public static function activated(): self
    {
        return new self(self::ACTIVATED_MESSAGE);
    }

    public static function userLimit(): self
    {
        return new self(self::USER_LIMIT_MESSAGE);
    }

    public static function endsAt(): self
    {
        return new self(self::ENDS_AT_MESSAGE);
    }

    public static function limit(): self
    {
        return new self(self::LIMIT_MESSAGE);
    }

    public static function notFound(): self
    {
        return new self(self::NOT_FOUND_MESSAGE);
    }
}
