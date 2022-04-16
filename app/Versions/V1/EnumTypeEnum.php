<?php

namespace App\Versions\V1;

enum EnumTypeEnum: string
{
    case CREATE_TYPE = 'created';
    case UPDATE_TYPE = 'updated';
    case DELETE_TYPE = 'deleted';
}
