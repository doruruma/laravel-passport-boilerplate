<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function signIn($email, $password)
    {
        return $this->postJson('/api/user/sign-in', [
            'username' => $email,
            'password' => $password
        ]);
    }

    public function testSignInSuccess(): void
    {
        $this->signIn('test@example.com', 'TEST_PASS')
            ->assertStatus(200)
            ->assertJsonStructure([
                'token_type',
                'expires_in',
                'access_token',
                'refresh_token'
            ]);
    }

    public function testSignInInvalidCredential(): void
    {
        $this->signIn('test@blabla.com', 'TEST_PASS')
            ->assertStatus(500)
            ->assertJson([
                "message" => "Email tidak terdaftar!"
            ]);
    }

    public function testRefreshTokenSuccess(): void
    {
        $response = $this->signIn('test@example.com', 'TEST_PASS');
        $this->postJson(
            '/api/user/refresh-token',
            ['refresh_token' => $response['refresh_token']],
            ['Authorization' => "Bearer " . $response['access_token']]
        )->assertStatus(200)
            ->assertJsonStructure([
                'token_type',
                'expires_in',
                'access_token',
                'refresh_token'
            ]);
    }

    public function testRefreshTokenInvalid(): void
    {
        $response = $this->signIn('test@example.com', 'TEST_PASS');
        Route::partialMock()
            ->shouldReceive('dispatch')
            ->once()
            ->andReturn(new \Illuminate\Http\Response(json_encode([
                'error' => 'invalid_grant',
                'message' => 'The refresh token is invalid.'
            ]), 400));
        $this->postJson(
            '/api/user/refresh-token',
            ['refresh_token' => $response['refresh_token']],
            ['Authorization' => "Bearer " . $response['access_token']]
        )->assertStatus(400)
            ->assertJson([
                'error' => 'invalid_grant',
                'message' => 'The refresh token is invalid.'
            ]);
    }
}
