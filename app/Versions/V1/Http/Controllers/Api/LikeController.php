<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Enums\LikeableTypeEnum;
use App\Enums\RateableTypeEnum;
use App\Enums\RateTypeEnum;
use App\Enums\RatingableTypeEnum;
use App\Exceptions\RatingsException;
use App\Versions\V1\Dto\LikeDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\LikeRequest;
use App\Versions\V1\Services\RateService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response as Status;
use function app;
use function response;

class LikeController extends Controller
{
    public function rate(
        LikeableTypeEnum $model,
        int $id,
        LikeRequest $request
    ): Response
    {
        $message = app(RateService::class, [
            'rateable' => $model->findModel($id),
            'user' => $request->user(),
            'type' => RateTypeEnum::LIKE_TYPE
        ])->rate(LikeDto::fromRequest($request));

        return response(['message' => $message]);
    }

    public function unRate(
        LikeableTypeEnum $model,
        int $id,
    ): Response
    {
        try {
            app(RateService::class, [
                'rateable' => $model->findModel($id),
                'user' => Auth::user(),
                'type' => RateTypeEnum::LIKE_TYPE
            ])->unRate();
        } catch (RatingsException $exception) {
            return response(['message' => $exception->getMessage()], Status::HTTP_BAD_REQUEST);
        }

        return response(['message' => Lang::get("rateable.delete")]);
    }
}
