<?php

namespace App\Versions\V1\Services;

use App\Dto\MangaDto;
use App\Models\Manga;
use App\Versions\V1\Repositories\MangaRepository;

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
            ->syncFilter($dto);

        return $this->manga;
    }

    public function update(MangaDto $dto): Manga
    {
        $this->repository
            ->fill($dto)
            ->save()
            ->addMedia($dto)
            ->syncFilter($dto);

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
