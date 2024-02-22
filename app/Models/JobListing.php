<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = ['job_title', 'company_name', 'location', 'description', 'instructions', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'job_listing_id', 'id');
    }
}
