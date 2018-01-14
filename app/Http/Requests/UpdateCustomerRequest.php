<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
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
        $customer = $this->route('customer');

        return [
            'name' => [
                'required',
                Rule::unique('customers')->ignore($customer->id)
            ],
            'gender' => [
                'required',
                Rule::in(['M', 'F'])
            ],
            'telephone' => 'nullable|numeric',
            'email' => 'nullable|email'
        ];
    }
}
