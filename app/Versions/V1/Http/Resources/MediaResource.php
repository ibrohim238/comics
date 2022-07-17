<?php

namespace App\Versions\V1\Http\Resources;

use App\Versions\V1\Dto\FallbackMedia;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @mixin Media | FallbackMedia
 */
class MediaResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'src' => $this->getUrl(),
        ];
    }
}
