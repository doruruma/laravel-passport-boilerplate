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
    /**
     * @OA\Post(
     *     path="/api/user/sign-in",
     *     tags={"Authentication"},
     *     summary="User Sign In",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"username", "password"},
     *             @OA\Property(property="username", type="string", example="test@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sign In Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="token_type", type="string"),
     *             @OA\Property(property="expires_in", type="integer"),
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="refresh_token", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid Email or Password"
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/user/refresh-token",
     *     tags={"Authentication"},
     *     summary="Refresh Token",
     *     security={{"passport": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"refresh_token"},
     *             @OA\Property(property="refresh_token", type="string", example="eyJ0eXAiOiJKV...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token",
     *         @OA\JsonContent(
     *             @OA\Property(property="token_type", type="string"),
     *             @OA\Property(property="expires_in", type="integer"),
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="refresh_token", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Expired or Invalid Refresh Token"
     *     )
     * )
     */
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
