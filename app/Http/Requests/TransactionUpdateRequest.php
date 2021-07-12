<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'value' => ['required', 'numeric'],
            'description' => ['nullable', 'max:255', 'string'],
            'prize_id' => ['required', 'exists:prizes,id'],
            'product_id' => ['nullable', 'exists:products,id'],
            'user_id' => ['required', 'exists:users,id'],
            'done_at' => ['required', 'date'],
        ];
    }
}
