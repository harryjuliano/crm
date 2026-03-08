<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OpportunityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $opportunityId = $this->route('opportunity')?->id;

        return [
            'opportunity_no' => 'required|string|max:255|unique:opportunities,opportunity_no,'. $opportunityId,
            'title' => 'required|string|max:255',
            'lead_id' => 'nullable|exists:leads,id',
            'customer_id' => 'nullable|exists:customers,id',
            'assigned_to' => 'nullable|exists:users,id',
            'opportunity_type' => 'required|in:product,service,mixed',
            'estimated_value' => 'nullable|numeric|min:0',
            'probability' => 'nullable|integer|min:0|max:100',
            'stage' => 'required|in:qualification,need_analysis,proposal,negotiation,waiting_approval,won,lost',
            'status' => 'required|in:open,won,lost,cancelled',
        ];
    }
}
