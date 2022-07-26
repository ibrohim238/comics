<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Enums\RateableTypeEnum;
use App\Enums\RateTypeEnum;
use App\Enums\RatingableTypeEnum;
use App\Enums\VotableTypeEnum;
use App\Exceptions\RatingsException;
use App\Versions\V1\Dto\RateDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\RateRequest;
use App\Versions\V1\Services\RateService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response as Status;
use function app;
use function response;

class VoteController extends Controller
{
    public function rate(VotableTypeEnum $model, int $id,): Response
    {
        $message = app(RateService::class, [
            'rateable' => $model->identify($id),
            'user' => Auth::user(),
            'type' => RateTypeEnum::RATING_TYPE
        ])->rate();

        return response(['message' => $message]);
    }

    public function unRate(VotableTypeEnum $model, int $id,): Response
    {
        try {
            app(RateService::class, [
                'rateable' => $model->identify($id),
                'user' => Auth::user(),
                'type' => RateTypeEnum::VOTE_TYPE
            ])->unRate();
        } catch (RatingsException $exception) {
            return response(['message' => $exception->getMessage()], Status::HTTP_BAD_REQUEST);
        }

        return response(['message' => Lang::get("rateable.delete")]);
    }
}
