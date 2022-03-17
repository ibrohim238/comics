<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\UserRequest;
use App\Versions\V1\Http\Resources\UserResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function show()
    {
        return new UserResource(Auth::user());
    }

    public function update(UserRequest $request)
    {
        $user = Auth::user();

        $user->update($request->only('name', 'email', 'password'));

        return new UserResource($user);
    }

    public function destroy()
    {
        Auth::user()->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
