<?php

namespace App\Versions\V1\Dto;

use App\Versions\V1\Http\Requests\Api\Admin\UserRequest;
use Spatie\DataTransferObject\DataTransferObject;

class AdminUserDto extends DataTransferObject
{
    public string $password;

    public static function fromRequest(UserRequest $request): AdminUserDto
    {
        return new self($request->validated());
    }
}
