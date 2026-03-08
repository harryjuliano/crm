<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadSourceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $leadSourceId = $this->route('lead_source')?->id;

        return [
            'code' => 'required|string|max:255|unique:lead_sources,code,'. $leadSourceId,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ];
    }
}
