<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class CreateStoreConfigsRequest extends FormRequest
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
            'name' => 'required',
            'short_name' => 'required',
            'picture' => 'nullable',
            'location' => 'nullable',
            'address' => 'nullable',
            'timezone' => 'required',
            'tax_percent' => 'required|numeric',
            'receipt_contents' => 'nullable'
        ];
    }
}
