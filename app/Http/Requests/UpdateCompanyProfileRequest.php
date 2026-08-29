<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyProfileRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->company;
    }

    public function rules()
    {
        return [
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'certifications' => 'nullable|array',
            'certifications.*' => 'string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:4096',
        ];
    }
}
