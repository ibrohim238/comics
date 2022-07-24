<?php

namespace App\Versions\V1\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Versions\V1\Dto\UserDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Admin\UserRequest;
use App\Versions\V1\Http\Resources\UserCollection;
use App\Versions\V1\Http\Resources\UserResource;
use App\Versions\V1\Repositories\UserRepository;
use App\Versions\V1\Services\UserService;
use Illuminate\Http\Request;
use function app;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    public function index(Request $request): UserCollection
    {
        $users = app(UserRepository::class)
            ->paginate($request->get('count'));

        return new UserCollection($users);
    }

    public function show(User $user): UserResource
    {
        return new UserResource(
            app(UserRepository::class, [
                'user' => $user
            ])->getUser()
        );
    }

    public function store(UserRequest $request)
    {
        $user = app(UserService::class)
            ->store(UserDto::fromRequest($request));

        return new UserResource($user);
    }

    public function update(User $user, UserRequest $request)
    {
        app(UserService::class, [
            'user' => $user
        ])->update(UserDto::fromRequest($request));

        return new UserResource($user);
    }
}
