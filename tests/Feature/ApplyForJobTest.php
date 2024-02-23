<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ApplyForJobTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_apply_endpoint_submits_data()
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

        $listingData = [
            'job_title' => 'Senior Laravel Developer',
            'company_name' => 'FireFly Tech',
            'description' => 'Hello world',
            'instructions' => 'Hello world',
            'location' => 'Zero KM, Pokhara'
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->postJson(route('api.listings.store'), $listingData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'listing' => [
                    'id',
                    'job_title',
                    'company_name',
                    'description',
                    'instructions',
                    'location',
                    'created_at',
                    'updated_at',
                ]
            ]);

        $pdf = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $data = [
            'resume' => $pdf,
            'cover_letter' => 'Hello world'
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->postJson(route('api.listing.apply', ['id' => $response['listing']['id']]), $data);

        $response->assertStatus(201)->assertJson(['message' => 'Applied successfully']);
    }
}
