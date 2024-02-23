<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\V1\SearchJobListingController;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SearchJobListingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_search_job_listings()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        JobListing::query()->create([
            'user_id' => $user->id
        ]);

        $queryParameters = [
            'location' => '',
            'title' => '',
        ];

        $request = Request::create(route('api.listing.search'), 'GET', $queryParameters);

        $controller = new SearchJobListingController();

        $response = $controller->__invoke($request);

        $this->assertEquals(200, $response->status());
        $this->assertArrayHasKey('listings', json_decode($response->getContent(), true));
    }
}
