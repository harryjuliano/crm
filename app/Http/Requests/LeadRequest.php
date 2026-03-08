<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $leadId = $this->route('lead')?->id;

        return [
            'lead_no' => 'required|string|max:255|unique:leads,lead_no,'. $leadId,
            'name' => 'required|string|max:255',
            'lead_type' => 'required|in:company,individual',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:255',
            'lead_source_id' => 'nullable|exists:lead_sources,id',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|in:new,contacted,qualified,unqualified,converted,lost',
        ];
    }
}
