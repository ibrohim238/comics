<?php

namespace App\Versions\V1\Services;

use App\Versions\V1\Repositories\MediaApiRepository;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use function app;

class MediaService
{
    private MediaApiRepository $repository;

    public function __construct(
        private Media $media
    ) {
        $this->repository = app(MediaApiRepository::class, [
            'media' => $this->media
        ]);
    }

    public function destroy(): void
    {
        $this->repository
            ->delete();
    }
}
