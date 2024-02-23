<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class SearchJobListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_listing_endpoint_searches_and_returns_listings(): void
    {
        $queryParameters = [
            'location' => '',
            'title' => '',
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->getJson(route('api.listing.search', $queryParameters));

        $response->assertStatus(200)->assertJsonStructure([
            'message',
            'listings'
        ]);
    }
}
