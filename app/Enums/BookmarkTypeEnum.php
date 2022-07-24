<?php

namespace App\Enums;

enum BookmarkTypeEnum: int
{
    use EnumTrait;

    case reading = 1;
    case interesting = 2;
    case read = 3;
    case deferred = 4;
    case dropped = 5;
    case notInteresting = 6;
}