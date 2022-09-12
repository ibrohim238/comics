<?php

namespace App\Versions\V1\Services;

use App\Versions\V1\Dto\HasMediaDto;
use App\Versions\V1\Repositories\HasMediaApiRepository;
use Spatie\MediaLibrary\HasMedia;
use function app;

class HasMediaService
{
    private HasMediaApiRepository $repository;

    public function __construct(
        private HasMedia $hasMedia,
    )
    {
        $this->repository = app(HasMediaApiRepository::class, [
            'hasMedia' => $this->hasMedia
        ]);
    }

    public function store(HasMediaDto $dto): void
    {
        $this->repository
            ->addMedia($dto->media)
            ->addMediaFromUrl($dto->media_urls);
    }

    public function xmlParser()
    {

    }
}
