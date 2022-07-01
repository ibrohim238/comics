<?php

namespace App\Versions\V1\Http\Resources;

use App\Models\Filter;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Filter
*/
class FilterResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
