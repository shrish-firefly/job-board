<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\V1\JobListingController;
use App\Http\Requests\Api\V1\StoreJobListingRequest;
use App\Http\Requests\Api\V1\UpdateJobListingRequest;
use App\Models\JobListing;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Tests\TestCase;

class JobListingControllerTest extends TestCase
{
    public function test_it_can_return_job_listings()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        JobListing::query()->create([
            'user_id' => $user->id
        ]);

        $controller = new JobListingController();

        $response = $controller->index();

        $this->assertEquals(200, $response->status());
        $this->assertArrayHasKey('listings', json_decode($response->getContent(), true));
    }

    public function test_it_can_store_a_job_listing()
    {
        $request = Mockery::mock(StoreJobListingRequest::class);
        $request->shouldReceive('validated')->once()->andReturn([
            'job_title' => 'Software Engineer',
            'company_name' => 'Firefly tech',
            'location' => 'Pokhara',
            'description' => 'We are looking for a software engineer...',
            'instructions' => 'We are looking for a software engineer...',
        ]);

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $controller = new JobListingController();

        $response = $controller->store($request);

        $this->assertEquals(200, $response->status());
        $this->assertArrayHasKey('listing', json_decode($response->getContent(), true));
    }

    public function test_it_can_return_a_job_listing()
    {
        $request = Mockery::mock(StoreJobListingRequest::class);
        $request->shouldReceive('validated')->once()->andReturn([
            'job_title' => 'Software Engineer',
            'company_name' => 'Firefly tech',
            'location' => 'Pokhara',
            'description' => 'We are looking for a software engineer...',
            'instructions' => 'We are looking for a software engineer...',
        ]);

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $controller = new JobListingController();

        $response = $controller->store($request);

        $this->assertEquals(200, $response->status());
        $this->assertArrayHasKey('listing', json_decode($response->getContent(), true));

        $listing_id = json_decode($response->getContent(), true)['listing']['id'];

        $response = $controller->show($listing_id);

        $this->assertEquals(200, $response->status());
        $this->assertArrayHasKey('listing', json_decode($response->getContent(), true));
    }

    public function test_it_can_update_a_job_listing()
    {
        $request = Mockery::mock(StoreJobListingRequest::class);
        $request->shouldReceive('validated')->once()->andReturn([
            'job_title' => 'Software Engineer',
            'company_name' => 'Firefly tech',
            'location' => 'Pokhara',
            'description' => 'We are looking for a software engineer...',
            'instructions' => 'We are looking for a software engineer...',
        ]);

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $controller = new JobListingController();

        $response = $controller->store($request);

        $this->assertEquals(200, $response->status());
        $this->assertArrayHasKey('listing', json_decode($response->getContent(), true));

        $listing_id = json_decode($response->getContent(), true)['listing']['id'];

        $request = Mockery::mock(UpdateJobListingRequest::class);

        $request->shouldReceive('validated')->once()->andReturn([
            'job_title' => 'Senior laravel developer',
        ]);

        $response = $controller->update($request, $listing_id);

        $this->assertEquals(200, $response->status());
        $this->assertArrayHasKey('listing', json_decode($response->getContent(), true));
    }
    
    public function test_it_can_delete_a_job_listing()
    {
        $request = Mockery::mock(StoreJobListingRequest::class);
        $request->shouldReceive('validated')->once()->andReturn([
            'job_title' => 'Software Engineer',
            'company_name' => 'Firefly tech',
            'location' => 'Pokhara',
            'description' => 'We are looking for a software engineer...',
            'instructions' => 'We are looking for a software engineer...',
        ]);

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $controller = new JobListingController();

        $response = $controller->store($request);

        $this->assertEquals(200, $response->status());
        $this->assertArrayHasKey('listing', json_decode($response->getContent(), true));

        $listing_id = json_decode($response->getContent(), true)['listing']['id'];

        $response = $controller->destroy($listing_id);

        $this->assertEquals(200, $response->status());
        $this->assertArrayHasKey('listing', json_decode($response->getContent(), true));
    }

    public function test_it_can_return_a_job_listing_applications()
    {
        $request = Mockery::mock(StoreJobListingRequest::class);
        $request->shouldReceive('validated')->once()->andReturn([
            'job_title' => 'Software Engineer',
            'company_name' => 'Firefly tech',
            'location' => 'Pokhara',
            'description' => 'We are looking for a software engineer...',
            'instructions' => 'We are looking for a software engineer...',
        ]);

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $controller = new JobListingController();

        $response = $controller->store($request);

        $this->assertEquals(200, $response->status());
        $this->assertArrayHasKey('listing', json_decode($response->getContent(), true));

        $listing_id = json_decode($response->getContent(), true)['listing']['id'];

        $response = $controller->applications($listing_id);

        $this->assertEquals(200, $response->status());
        $this->assertArrayHasKey('applications', json_decode($response->getContent(), true));
    }
}
