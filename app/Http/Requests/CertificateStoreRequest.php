<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificateStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'country_id' => ['required', 'exists:countries,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'year' => ['required', 'date'],
            'university_id' => ['required', 'exists:universities,id'],
            'graduation_id' => ['required', 'exists:graduations,id'],
            'result_id' => ['required', 'exists:results,id'],
            'remark_id' => ['required', 'exists:remarks,id'],
            'image' => ['image', 'max:1024', 'nullable'],
        ];
    }
}
