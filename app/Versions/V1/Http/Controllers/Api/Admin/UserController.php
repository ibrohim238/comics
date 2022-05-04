<?php

namespace App\Versions\V1\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Versions\V1\Dto\AdminUserDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\Admin\UserRequest;
use App\Versions\V1\Http\Resources\UserCollection;
use App\Versions\V1\Http\Resources\UserResource;
use App\Versions\V1\Services\Admin\UserService;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->get();

        return new UserCollection($users);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(User $user, UserRequest $request)
    {
        app(UserService::class, [$user])->update(AdminUserDto::fromRequest($request));

        return new UserResource($user);
    }
}
