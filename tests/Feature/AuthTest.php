<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_endpoint_creates_user_successfully()
    {
        $userData = [
            'name' => 'Pawan Bhatta',
            'email' => 'testuser@gmail.com',
            'password' => 'Qwertaaeeyuiop12@',
            'password_confirmation' => 'Qwertaaeeyuiop12@'
        ];

        $response = $this->postJson(route('api.auth.register'), $userData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    public function test_register_endpoint_returns_error_for_existing_email()
    {
        $userData = [
            'name' => 'Pawan Bhatta',
            'email' => 'testuser@gmail.com',
            'password' => 'Qwertaaeeyuiop12@',
            'password_confirmation' => 'Qwertaaeeyuiop12@'
        ];

        $response = $this->postJson(route('api.auth.register'), $userData);
        $response = $this->postJson(route('api.auth.register'), $userData);

        $response->assertStatus(422);
    }

    public function test_login_endpoint_returns_token_on_valid_credentials()
    {
        $userData = [
            'name' => 'Pawan Bhatta',
            'email' => 'testuser@gmail.com',
            'password' => 'Qwertaaeeyuiop12@',
            'password_confirmation' => 'Qwertaaeeyuiop12@'
        ];

        $response = $this->postJson(route('api.auth.register'), $userData);

        $credentials = [
            'email' => 'testuser@gmail.com',
            'password' => 'Qwertaaeeyuiop12@',
        ];

        $response = $this->postJson(route('api.auth.login'), $credentials);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user',
                'authorization' => [
                    'token',
                    'type'
                ]
            ]);
    }

    public function test_login_endpoint_returns_unauthorized_on_invalid_credentials()
    {
        $userData = [
            'name' => 'Pawan Bhatta',
            'email' => 'testuser@gmail.com',
            'password' => 'Qwertaaeeyuiop12@',
            'password_confirmation' => 'Qwertaaeeyuiop12@'
        ];

        $response = $this->postJson(route('api.auth.register'), $userData);

        $credentials = [
            'email' => 'testuser@gmail.com',
            'password' => 'Qwertaaeeyuiop12',
        ];

        $response = $this->postJson(route('api.auth.login'), $credentials);

        $response->assertStatus(401)->assertJson([
            'message' => 'Invalid credentials'
        ]);
    }

    public function test_user_endpoint_returns_unauthorized_on_invalid_bearer_token()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer invalid_token',
        ])->getJson(route('api.auth.user'));

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    public function test_user_endpoint_returns_user_on_valid_bearer_token()
    {
        $userData = [
            'name' => 'Pawan Bhatta',
            'email' => 'testuser@gmail.com',
            'password' => 'Qwertaaeeyuiop12@',
            'password_confirmation' => 'Qwertaaeeyuiop12@'
        ];
        $this->postJson(route('api.auth.register'), $userData);

        $credentials = [
            'email' => 'testuser@gmail.com',
            'password' => 'Qwertaaeeyuiop12@',
        ];
        $loginResponse = $this->postJson(route('api.auth.login'), $credentials);

        $token = $loginResponse['authorization']['token'];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token",
        ])->getJson(route('api.auth.user'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }
}
