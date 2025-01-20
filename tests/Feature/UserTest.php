<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
    public function testSignInSuccess(): void
    {
        $this->postJson('/api/user/sign-in', [
            'username' => 'test@example.com',
            'password' => 'TEST_PASS'
        ])->assertStatus(200)
            ->assertJsonStructure([
                'token_type',
                'expires_in',
                'access_token',
                'refresh_token'
            ]);
    }

    public function testSignInInvalidCredential(): void
    {
        $this->postJson('/api/user/sign-in', [
            'username' => 'test@blablabla.com',
            'password' => 'TEST_PASS',
        ])->assertStatus(500)
            ->assertJson([
                "message" => "Email tidak terdaftar!"
            ]);
    }
}
