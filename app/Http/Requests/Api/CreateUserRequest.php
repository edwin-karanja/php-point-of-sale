<?php

namespace App\Http\Requests\Api;

use App\Bags\UserBag;
use App\Http\Contracts\Baggable;
use App\Http\Requests\ApiFormRequests;
use Illuminate\Validation\Rule;

class CreateUserRequest extends ApiFormRequests implements Baggable
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'gender' => [
                'required',
                Rule::in(['M', 'F'])
            ],
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function toBag(): object
    {
        return new UserBag(
            $this->validated()
        );
    }
}
