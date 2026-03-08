<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'activity_no' => 'nullable|string|max:255',
            'relatable_type' => 'required|in:App\Models\Lead,App\Models\Opportunity,App\Models\Customer',
            'relatable_id' => 'required|integer|min:1',
            'user_id' => 'required|exists:users,id',
            'activity_type' => 'required|in:call,email,whatsapp,meeting,visit,demo,presentation,follow_up,reminder,other',
            'subject' => 'required|string|max:255',
            'activity_at' => 'required|date',
            'status' => 'required|in:planned,done,cancelled,overdue',
        ];
    }
}
