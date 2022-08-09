<?php

namespace App\Versions\V1\Http\Controllers\Api\Auth;

use App\Versions\V1\Dto\UserDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\RegisterRequest;
use App\Versions\V1\Http\Resources\UserResource;
use App\Versions\V1\Services\UserService;
use function app;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(RegisterRequest $request)
    {
        $user = app(UserService::class)
            ->store(UserDto::fromRequest($request));

        return new UserResource($user);
    }
}
