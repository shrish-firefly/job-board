<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JobListingTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_index_endpoint_returns_listings()
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
            'Authorization' => "Bearer $token"
        ])->getJson(route('api.listings.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'listings'
            ]);
    }

    public function test_store_endpoint_adds_new_lisiting()
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
    }

    public function test_show_endpoint_returns_a_lisitng()
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

        $dataResponse = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->getJson(route('api.listings.show', ['listing' => $response['listing']['id']]));

        $dataResponse->assertStatus(200)
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
    }

    public function test_update_endpoint_updates_a_lisitng()
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

        $listingData = [
            '_method' => 'PUT',
            'job_title' => 'Senior PHP Developer',
        ];

        $dataResponse = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token",
        ])->postJson(route('api.listings.update', ['listing' => $response['listing']['id']]), $listingData);

        $dataResponse->assertStatus(200)
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
    }

    public function test_destroy_endpoint_deletes_a_lisitng()
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

        $listingData = [
            '_method' => 'DELETE',
        ];

        $dataResponse = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token",
        ])->postJson(route('api.listings.destroy', ['listing' => $response['listing']['id']]), $listingData);

        $dataResponse->assertStatus(200)
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
    }

    public function test_application_endpoint_returns_all_applications_related_to_a_lisitng()
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

        $dataResponse = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token",
        ])->getJson(route('api.listing.applications', ['id' => $response['listing']['id']]));

        $dataResponse->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'applications'
            ]);
    }
}
