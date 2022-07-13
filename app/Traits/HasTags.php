<?php

namespace App\Traits;

use App\Enums\TagTypeEnum;

use IAleroy\Tags\HasTags as BaseHasTags;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    use BaseHasTags;

    public function categories(): MorphToMany
    {
        return $this->filterType(TagTypeEnum::CATEGORY_TYPE);
    }

    public function tags(): MorphToMany
    {
        return $this->filterType(TagTypeEnum::TAG_TYPE);
    }

    public function genres(): MorphToMany
    {
        return $this->filterType(TagTypeEnum::GENRE_TYPE);
    }
}
