<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Enums\RateableTypeEnum;
use App\Enums\RateTypeEnum;
use App\Enums\RatingableTypeEnum;
use App\Exceptions\RatingsException;
use App\Versions\V1\Dto\RateDto;
use App\Versions\V1\Dto\RatingDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\RateRequest;
use App\Versions\V1\Http\Requests\RatingRequest;
use App\Versions\V1\Services\RateService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response as Status;
use function app;
use function response;

class RatingController extends Controller
{
    public function rate(
        RatingableTypeEnum $model,
        int $id,
        RatingRequest $request
    ): Response
    {
        $message = app(RateService::class, [
            'rateable' => $model->identify($id),
            'user' => $request->user(),
            'type' => RateTypeEnum::RATING_TYPE
        ])->rate(RatingDto::fromRequest($request));

        return response(['message' => $message]);
    }

    public function unRate(
        RateableTypeEnum $model,
        int $id,
    ): Response
    {
        try {
            app(RateService::class, [
                'rateable' => $model->identify($id),
                'user' => Auth::user(),
                'type' => RateTypeEnum::RATING_TYPE
            ])->unRate();
        } catch (RatingsException $exception) {
            return response(['message' => $exception->getMessage()], Status::HTTP_BAD_REQUEST);
        }

        return response(['message' => Lang::get("rateable.delete")]);
    }
}
