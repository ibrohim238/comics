<?php

namespace App\Enums;

enum EnumTypeEnum: string
{
    case CREATE_TYPE = 'created';
    case UPDATE_TYPE = 'updated';
    case DELETE_TYPE = 'deleted';
}