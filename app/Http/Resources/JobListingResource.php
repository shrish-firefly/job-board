<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'job_title' => $this->job_title,
            'company_name' => $this->company_name,
            'location' => $this->location,
            'description' => $this->description,
            'instructions' => $this->instructions,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
