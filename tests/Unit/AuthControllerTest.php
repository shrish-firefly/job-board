<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_register_a_user()
    {
        $request = Mockery::mock(RegisterRequest::class);
        $request->shouldReceive('validated')->once()->andReturn(['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'password']);
        $controller = new AuthController();
        $response = $controller->register($request);
        $this->assertEquals(201, $response->status());
        $this->assertArrayHasKey('user', json_decode($response->getContent(), true));
    }

    public function test_it_can_login_a_user()
    {
        $request = Mockery::mock(RegisterRequest::class);
        $request->shouldReceive('validated')->once()->andReturn(['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'password']);
        $controller = new AuthController();
        $response = $controller->register($request);
        $this->assertEquals(201, $response->status());
        $this->assertArrayHasKey('user', json_decode($response->getContent(), true));
        $request = Mockery::mock(LoginRequest::class);
        $request->shouldReceive('validated')->once()->andReturn(['email' => 'john@example.com', 'password' => 'password']);
        $response = $controller->login($request);
        $this->assertEquals(200, $response->status());
        $this->assertArrayHasKey('user', json_decode($response->getContent(), true));
        $this->assertArrayHasKey('authorization', json_decode($response->getContent(), true));
    }

    public function test_it_can_logout_a_user()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $controller = new AuthController();
        $response = $controller->logout(request());
        $this->assertEquals(200, $response->status());
        $this->assertJson($response->getContent());
        $this->assertStringContainsString('Logged out successfully', $response->getContent());
    }

    public function test_it_can_get_authenticated_user()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $controller = new AuthController();
        $response = $controller->user(request());
        $this->assertEquals(200, $response->status());
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('user', $responseData);
        $this->assertEquals($user->toArray(), $responseData['user']);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
