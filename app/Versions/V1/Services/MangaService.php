<?php

namespace App\Versions\V1\Services;

use App\Models\Manga;
use App\Versions\V1\Dto\MangaDto;
use App\Versions\V1\Repositories\MangaRepository;
use function app;

class MangaService
{
    private MangaRepository $repository;

    public function __construct(
        private Manga $manga,
    ) {
        $this->repository = app(MangaRepository::class, [
           'manga' => $this->manga
        ]);
    }

    public function store(MangaDto $dto): Manga
    {
        $this->repository
            ->fill($dto)
            ->save()
            ->addMedia($dto)
            ->syncTags($dto);

        return $this->manga;
    }

    public function update(MangaDto $dto): Manga
    {
        $this->repository
            ->fill($dto)
            ->save()
            ->addMedia($dto)
            ->syncTags($dto);

        return $this->manga;
    }

    public function delete(): void
    {
        $this->repository
            ->deleteChapters()
            ->deleteMedia()
            ->delete();
    }
}
