<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $customerId = $this->route('customer')?->id;

        return [
            'customer_code' => 'required|string|max:255|unique:customers,customer_code,'. $customerId,
            'name' => 'required|string|max:255',
            'customer_type' => 'required|in:company,individual',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,blacklisted',
        ];
    }
}
