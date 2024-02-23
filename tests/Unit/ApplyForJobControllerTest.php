<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\V1\ApplyForJobController;
use App\Http\Controllers\Api\V1\JobListingController;
use App\Http\Requests\Api\V1\ApplyForJobRequest;
use App\Http\Requests\Api\V1\StoreJobListingRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Tests\TestCase;

class ApplyForJobControllerTest extends TestCase
{
    use RefreshDatabase;
    
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

        $listing_id = json_decode($response->getContent(), true)['listing']['id'];

        $pdf = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $applyForJobRequest = new ApplyForJobRequest([
            'cover_letter' => 'Pawan Bhatta',
            'resume' => $pdf,
        ]);

        $controller = new ApplyForJobController();

        $response = $controller->__invoke($applyForJobRequest, $listing_id);

        $this->assertEquals(201, $response->status());
        $this->assertArrayHasKey('message', json_decode($response->getContent(), true));
    }
}
