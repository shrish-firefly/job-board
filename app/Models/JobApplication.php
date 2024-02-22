<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = ['resume', 'cover_letter', 'job_listing_id'];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(JobListing::class, 'job_listing_id', 'id');
    }
}
