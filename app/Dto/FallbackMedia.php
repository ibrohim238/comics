<?php

namespace App\Dto;

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
