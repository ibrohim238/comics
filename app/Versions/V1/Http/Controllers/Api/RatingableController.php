<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Exceptions\LikealeException;
use App\Exceptions\RatingableException;
use App\Models\Manga;
use App\Versions\V1\Dto\RatingDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\RatingRequest;
use App\Versions\V1\Services\RatingService;
use App\Versions\V1\Traits\IdentifiesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class RatingableController extends Controller
{
    use IdentifiesModels;

    /**
     * @throws UnknownProperties
     */
    public function updateOrCreate(string $model, int $id, RatingRequest $request)
    {
        $model = $this->identifyModel($model, $id);

        app(RatingService::class, [
            'rateable' => $model,
            'user' => Auth::user(),
            ])->updateOrCreate(RatingDto::fromRequest($request));

        return response(Lang::get('ratingable.updateOrCreate'));
    }

    public function delete(string $model, int $id)
    {
        $model = $this->identifyModel($model, $id);

        try {
            app(RatingService::class, [
                'rateable' => $model,
                'user' => Auth::user()
            ])->delete();
        } catch (RatingableException $exception) {
            return response($exception->getMessage());
        }

        return response(Lang::get('ratingable.delete'));
    }
}
