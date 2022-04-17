<?php

namespace App\Versions\V1\Http\Resources;

use App\Models\Rating;
use Illuminate\Http\Resources\Json\JsonResource;
/**
 * @mixin Rating
*/
class RatingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
          'rating' => $this->avg('rating')
        ];
    }
}
