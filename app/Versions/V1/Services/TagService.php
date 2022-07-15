<?php

namespace App\Versions\V1\Services;

use App\Dto\TagDto;
use App\Versions\V1\Repositories\TagRepository;
use IAleroy\Tags\Tag;

class TagService
{
    public TagRepository $repository;

    public function __construct(
        public Tag $tag
    ) {
        $this->repository = app(TagRepository::class, [
           'tag' => $this->tag
        ]);
    }

    public function store(TagDto $dto): Tag
    {
        $this->repository
            ->fill($dto)
            ->save();

        return $this->tag;
    }

    public function update(TagDto $dto): Tag
    {
        $this->repository
            ->fill($dto)
            ->save();

        return $this->tag;
    }

    public function delete(): void
    {
        $this->repository
            ->delete();
    }
}
