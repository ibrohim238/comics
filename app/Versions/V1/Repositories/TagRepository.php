<?php

namespace App\Versions\V1\Repositories;

use App\Versions\V1\Dto\TagDto;
use App\Models\Tag;

class TagRepository
{
    public function __construct(
        private Tag $tag
    ) {
    }

    public function fill(TagDto $dto): static
    {
        $this->tag->fill($dto->toArray());

        return $this;
    }

    public function save(): static
    {
        $this->tag->save();

        return $this;
    }

    public function delete(): static
    {
        $this->tag->delete();

        return $this;
    }
}
