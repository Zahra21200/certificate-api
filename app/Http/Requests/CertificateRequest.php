<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'national_id' => 'required|string|unique:certificates,national_id|max:20',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'hours' => 'required|integer|min:1',
        ];
    }

}
