<?php

namespace App\Versions\V1\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Laravel\Passport\Client;

class AuthController
{
    public function login(Request $request)
    {
        $client = Client::where('password_client', 1)->first();

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $request->username,
            'password' => $request->password,
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        return \Route::dispatch($proxy);
    }

    public function refresh(Request $request)
    {
        $client = Client::where('password_client', 1)->first();

        $request->request->add([
            'grant_type' => 'refresh_token',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'refresh_token' => $request->refresh_token,
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        return \Route::dispatch($proxy);
    }
}