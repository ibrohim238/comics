<?php

namespace App\Versions\V1\Repositories;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaApiRepository
{
    public function __construct(
        private Media $media
    ) {
    }

    public function update(array $data): static
    {
        $this->media->update($data);

        return $this;
    }

    public function delete(): static
    {
        $this->media->delete();

        return $this;
    }
}
