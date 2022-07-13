<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Dto\RateDto;
use App\Exceptions\RatingsException;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\RateRequest;
use App\Versions\V1\Services\RatingService;
use Illuminate\Http\Request;
use Illuminate\Http\Response as ResponseAlias;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpFoundation\Response;

class RateableController extends Controller
{
    /**
     * @throws UnknownProperties
     */
    public function rate(string $model, int $id, RateRequest $request): ResponseAlias
    {
        $message = app(RatingService::class, [
            'rateable' => identifyModel($model, $id),
            'user' => Auth::user(),
        ])->rate(RateDto::fromRequest($request));

        return response(['message' => $message]);
    }

    public function unRate(string $model, int $id, Request $request): ResponseAlias
    {
        try {
            app(RatingService::class, [
                'rateable' => identifyModel($model, $id),
                'user' => Auth::user()
            ])->unRate($request->segment(3));
        } catch (RatingsException $exception) {
            return response(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response(['message' => Lang::get("rateable.delete")]);
    }
}
