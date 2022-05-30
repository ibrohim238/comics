<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Exceptions\RatingsException;
use App\Versions\V1\Dto\RateDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\RateRequest;
use App\Versions\V1\Services\RatingService;
use App\Versions\V1\Traits\IdentifiesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpFoundation\Response;

class RateableController extends Controller
{
    /**
     * @throws UnknownProperties
     */
    public function rate(string $model, int $id, RateRequest $request)
    {
        $model = identifyModel($model, $id);

        $message = app(RatingService::class, [
            'rateable' => $model,
            'user' => Auth::user(),
        ])->rate(RateDto::fromRequest($request));

        return response(['message' => $message]);
    }

    public function unRate(string $model, int $id)
    {
        $model = identifyModel($model, $id);
        $type = request()->segment(3);

        try {
            app(RatingService::class, [
                'rateable' => $model,
                'user' => Auth::user()
            ])->unRate($type);
        } catch (RatingsException $exception) {
            return response(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response(['message' => Lang::get('rateable.delete', ['type' => $type])]);
    }
}
