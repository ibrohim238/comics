<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Manga;
use App\Versions\V1\Dto\RatingDto;
use App\Versions\V1\Http\Requests\Api\RatingRequest;
use App\Versions\V1\Services\RatingService;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class MangaRatingController
{
    /**
     * @throws UnknownProperties
     */
    public function add(Manga $manga, RatingRequest $request)
    {
        app(RatingService::class, [$manga, Auth::user()])->add(RatingDto::fromRequest($request));
    }

    public function delete(Manga $manga)
    {
        app(RatingService::class, [$manga, Auth::user()])->delete();
    }
}
