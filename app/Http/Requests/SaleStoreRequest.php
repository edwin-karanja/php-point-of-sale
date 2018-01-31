<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleStoreRequest extends FormRequest
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
            'items.*.qtty_sold' => 'required|numeric|min:1',
            'items.*.selling_price' => 'required|numeric|min:1',
            'customer.id' => 'required',
            'payment_mode' => 'required',
            'amount_tendered' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'customer.id.required' => 'Please select a customer',
            'items.*.qtty_sold.min' => 'Qtty must be > 0',
            'items.*.qtty_sold.numeric' => 'Qtty must be numeric',
            'items.*.qtty_sold.required' => 'Qtty is required',
            'items.*.selling_price.numeric' => 'Price must be numeric',
            'items.*.selling_price.min' => 'Price must be > 0',
            'items.*.selling_price.required' => 'Price is required',
            'amount_tendered.required' => 'Enter the tendered amount'
        ];
    }
}
