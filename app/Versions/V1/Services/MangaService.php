<?php

namespace App\Versions\V1\Services;

use App\Models\Chapter;
use App\Models\Manga;
use App\Versions\V1\Dto\MangaDto;
use phpseclib3\File\ASN1\Maps\EncryptedData;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class MangaService
{
    public function __construct(
        public Manga $manga,
    ) {
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function save(MangaDto $dto): Manga
    {
        $this->manga->fill($dto->toArray())->save();
        $this->addMedia($dto);

        return $this->manga;
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function addMedia(MangaDto $dto)
    {
        if ($dto->image) {
            $this->manga->addMediaFromRequest('image')->toMediaCollection();
        }
    }

    public function delete()
    {
        $this->manga->chapters()->each(function (Chapter $chapter) {
            app(ChapterService::class, [$chapter])->delete();
        });
        $this->manga->clearMediaCollection();
        $this->manga->delete();
    }
}
