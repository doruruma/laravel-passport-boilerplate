<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\UserRefreshTokenFormRequest;
use App\Http\Requests\UserSignInFormRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    public function signIn(UserSignInFormRequest $request): JsonResponse
    {
        $user = User::where('email', $request->username)->first();
        if (!$user)
            return ResponseHelper::error('Email tidak terdaftar!');
        $request->merge([
            'grant_type'    => 'password',
            'client_id'     => config('auth.client_id'),
            'client_secret' => config('auth.client_secret'),
            'scope'         => '',
        ]);
        $proxy = Request::create('oauth/token', 'POST');
        $response = json_decode(Route::dispatch($proxy)->getContent(), true);
        $code = 200;
        if (array_key_exists('error', $response)) {
            $code = 400;
            if ($response['error'] == 'invalid_grant')
                $response = ['message' => 'Email atau password tidak valid!'];
        }
        return response()->json($response, $code);
    }

    public function refreshToken(UserRefreshTokenFormRequest $request): JsonResponse
    {
        $request->merge([
            'grant_type'    => 'refresh_token',
            'client_id'     => config('auth.client_id'),
            'client_secret' => config('auth.client_secret'),
            'scope'         => '',
        ]);
        $proxy = Request::create('oauth/token', 'POST');
        $response = json_decode(Route::dispatch($proxy)->getContent(), true);
        $code = 200;
        if (array_key_exists('error', $response))
            $code = 400;
        return response()->json($response, $code);
    }
}
