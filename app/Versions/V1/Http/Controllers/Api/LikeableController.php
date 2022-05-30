<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Exceptions\LikealeException;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Services\LikeableService;
use App\Versions\V1\Traits\IdentifiesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class LikeableController extends Controller
{
    use IdentifiesModels;

    public function add(string $model, int $id)
    {
        $model = $this->identifyModel($model, $id);

        try {
            app(LikeableService::class, [
                'likeable' => $model,
                'user' => Auth::user(),
            ])->add();
        } catch (LikealeException $exception) {
            return response($exception->getMessage());
        }

        return response(Lang::get('likeable.add'));
    }

    public function delete(string $model, int $id)
    {
        $model = $this->identifyModel($model, $id);

        try {
            app(LikeableService::class, [
                'likeable' => $model,
                'user' => Auth::user(),
            ])->delete();
        } catch (LikealeException $exception) {
            return response($exception->getMessage());
        }

        return response(Lang::get('likeable.delete'));
    }
}
