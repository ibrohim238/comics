<?php

namespace App\Versions\V1\Dto;

abstract class RateDto extends BaseDto
{
    public function getValue(): int
    {
        return $this->value;
    }
}
