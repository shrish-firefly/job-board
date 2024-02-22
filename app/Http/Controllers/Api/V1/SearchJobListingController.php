<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobListingCollection;
use App\Models\JobListing;
use Illuminate\Http\Request;

class SearchJobListingController extends Controller
{
    public function __invoke(Request $request)
    {
        $listings = JobListing::query();

        if ($request->query('title')) {
            $value = $request->query('title');
            $listings->where('job_title', 'LIKE', "%$value%");
        }

        if ($request->query('location')) {
            $value = $request->query('location');
            $listings->where('location', 'LIKE', "%$value%");
        }

        if ($request->query('company_name')) {
            $value = $request->query('company_name');
            $listings->where('company_name', 'LIKE', "%$value%");
        }

        $listings = $listings->get();

        return response()->json(['message' => '', 'listings' => new JobListingCollection($listings)], 200);
    }
}
