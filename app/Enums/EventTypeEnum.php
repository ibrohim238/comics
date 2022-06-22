<?php

namespace App\Enums;

enum EventTypeEnum: string
{
    use EnumTrait;

    case CREATE_TYPE = 'created';
    case UPDATE_TYPE = 'updated';
    case DELETE_TYPE = 'deleted';
    case ACTIVATE_TYPE = 'activated';
}
