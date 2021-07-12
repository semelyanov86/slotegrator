<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrizeUpdateRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'string'],
            'class' => ['required', 'max:255', 'string'],
            'inventory' => ['nullable', 'numeric'],
            'key' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'product_id' => ['nullable', 'exists:products,id'],
        ];
    }
}
