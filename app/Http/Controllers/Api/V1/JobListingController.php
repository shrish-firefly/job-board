<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreJobListingRequest;
use App\Http\Requests\Api\V1\UpdateJobListingRequest;
use App\Http\Resources\JobListingCollection;
use App\Http\Resources\JobListingResource;
use App\Models\JobListing;
use Illuminate\Support\Facades\Auth;

class JobListingController extends Controller
{
    public function index()
    {
        $listings = JobListing::query()->where('user_id', '=', Auth::id())->get();
        return response()->json(['message' => '', 'listings' => new JobListingCollection($listings)], 200);
    }

    public function store(StoreJobListingRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = Auth::id();

        $listing = JobListing::query()->create($data);

        return response()->json(['message' => 'Listing created successfully!', 'listing' => new JobListingResource($listing)], 200);
    }

    public function show(string $id)
    {
        $listing = JobListing::query()->where('user_id', '=', Auth::id())->where('id', '=', $id)->first();
        if (!$listing) {
            return response()->json(['message' => 'Listing not found!'], 404);
        }
        return response()->json(['message' => '', 'listing' => new JobListingResource($listing)], 200);
    }

    public function update(UpdateJobListingRequest $request, string $id)
    {
        $listing = JobListing::query()->where('user_id', '=', Auth::id())->where('id', '=', $id)->first();
        if (!$listing) {
            return response()->json(['message' => 'Listing not found!'], 404);
        }

        $data = $request->validated();

        $listing->update($data);

        return response()->json(['message' => 'Listing updated successfully!', 'listing' => new JobListingResource($listing)], 200);
    }

    public function destroy(string $id)
    {
        $listing = JobListing::query()->where('user_id', '=', Auth::id())->where('id', '=', $id)->first();
        if (!$listing) {
            return response()->json(['message' => 'Listing not found!'], 404);
        }

        $listing->delete();

        return response()->json(['message' => 'Listing deleted successfully!', 'listing' => new JobListingResource($listing)], 200);
    }
}
