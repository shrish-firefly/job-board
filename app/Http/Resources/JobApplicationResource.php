<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationResource extends JsonResource
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
            'resume' => url('uploads/resumes/' . $this->resume),
            'cover_letter' => $this->cover_letter,
            'submitted_at' => $this->created_at
        ];
    }
}
