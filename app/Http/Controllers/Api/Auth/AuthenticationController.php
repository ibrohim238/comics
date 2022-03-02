<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use function auth;

/**
 * @group Auth endpoints
 */
class AuthenticationController extends Controller
{
    /**
     * Shows authenticated user information
     *
     * @authenticated
     *
     * @response 200 {
     *     "id": 2,
     *     "name": "Demo",
     *     "email": "demo@demo.com",
     *     "email_verified_at": null,
     *     "created_at": "2020-05-25T06:21:47.000000Z",
     *     "updated_at": "2020-05-25T06:21:47.000000Z"
     * }
     * @response status=400 scenario="Unauthenticated" {
     *     "message": "Unauthenticated."
     * }
     */
    public function user()
    {
        $user = auth()->user();
        $avatar = $user->getFallbackMediaUrl();
        $user->image = $avatar;

        return $user;
    }
}
