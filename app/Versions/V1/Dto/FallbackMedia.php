<?php

namespace App\Versions\V1\Dto;

class FallbackMedia
{
    public function __construct(
        public string $collectionName,
        public string $url,
    ) {
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
