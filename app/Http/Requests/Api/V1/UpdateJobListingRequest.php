<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'job_title' => 'sometimes|string|min:2|max:150',
            'company_name' => 'sometimes|string|min:2|max:150',
            'location' => 'sometimes|string|min:2|max:100',
            'description' => 'sometimes|string|min:2|max:100000',
            'instructions' => 'sometimes|string|min:2|max:100000',
        ];
    }
}
