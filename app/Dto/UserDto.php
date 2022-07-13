<?php

namespace App\Dto;

use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UserDto extends DataTransferObject
{
    public string $name;
    public string $username;
    public string $email;
    public string $password;

    /**
     * @throws UnknownProperties
     */
    public static function fromArray(array $data): UserDto
    {
        return new self([
            'name' => $data['username'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
