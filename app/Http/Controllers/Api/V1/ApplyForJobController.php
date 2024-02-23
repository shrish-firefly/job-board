<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ApplyForJobRequest;
use App\Models\JobApplication;
use App\Models\JobListing;

class ApplyForJobController extends Controller
{
    public function __invoke(ApplyForJobRequest $request, string $id)
    {
        $listing = JobListing::query()->where('id', '=', $id)->first();
        if (!$listing) {
            return response()->json(['message' => 'Listing not found!'], 404);
        }

        $file_name = md5($request->resume) . "." . $request->resume->extension();

        $request->resume->move(public_path('uploads/resumes'), $file_name);

        JobApplication::query()->create([
            'resume' => $file_name,
            'cover_letter' => $request->cover_letter,
            'job_listing_id' => $listing->id
        ]);

        return response()->json(['message' => 'Applied successfully'], 201);
    }
}
