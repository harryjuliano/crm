<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OpportunityItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'opportunity_id' => 'required|exists:opportunities,id',
            'item_type' => 'required|in:product,service',
            'description' => 'nullable|string',
            'qty' => 'nullable|numeric|min:0',
            'estimated_price' => 'nullable|numeric|min:0',
            'estimated_discount_percent' => 'nullable|numeric|min:0|max:100',
            'subtotal' => 'nullable|numeric|min:0',
        ];
    }
}
