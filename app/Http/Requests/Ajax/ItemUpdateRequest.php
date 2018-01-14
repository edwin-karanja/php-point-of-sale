<?php

namespace App\Http\Requests\Ajax;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ItemUpdateRequest extends FormRequest
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
        $item = request()->route('item');
        return [
            'name' => [
                'required',
                Rule::unique('items')->ignore($item->id)
            ],
            'selling_price' => 'required|numeric',
            'buying_price' => 'required|numeric',
            'reorder_level' => 'nullable|numeric',
            'qtty' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'qtty.required' => 'The quantity field is required',
            'qtty.numeric' => 'The quantity must be a numeric value'
        ];
    }
}
