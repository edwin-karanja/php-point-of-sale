<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchasesStoreRequest extends FormRequest
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
            'items' => 'required|array',
            'items.*.qtty_purchased' => 'required|numeric|min:1',
            'items.*.buying_price' => 'required|numeric|min:1',
            'items.*.selling_price' => 'required|numeric|min:1',
            'supplier.id' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'items.*.qtty_purchased.min' => 'Qtty must be > 0',
            'items.*.qtty_purchased.numeric' => 'Qtty must be numeric',
            'items.*.qtty_purchased.required' => 'Qtty is required',
            'items.*.selling_price.numeric' => 'Price must be numeric',
            'items.*.selling_price.min' => 'Price must be > 0',
            'items.*.selling_price.required' => 'Price is required',
            'items.*.buying_price.numeric' => 'Price must be numeric',
            'items.*.buying_price.min' => 'Price must be > 0',
            'items.*.buying_price.required' => 'Price is required',
            'supplier.id.required' => 'Please select a supplier'
        ];
    }
}
