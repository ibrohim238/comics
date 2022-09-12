<?php

namespace App\Versions\V1\Repositories;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use function request;

class HasMediaApiRepository
{
    public function __construct(
        public HasMedia $hasMedia
    ) {
    }

    public function addMedia(?array $media): static
    {
        if ($media) {
            foreach ($media as $item) {
                /* @var UploadedFile $item */
                $this->hasMedia
                    ->addMedia($item)
                    ->withProperties(['hash' => md5_file($item->getRealPath())])
                    ->toMediaCollection();
            }
        }

        return $this;
    }
}
