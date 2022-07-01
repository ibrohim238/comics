<?php

namespace App\Versions\V1\Caster;

use Spatie\DataTransferObject\Caster;

class JsonCaster implements Caster
{

    public function cast(mixed $value): array
    {
        return json_decode($value, true);
    }
}
