<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PositiveValue implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->item = $item;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ((is_null($this->item->qtty) || empty($this->item->qtty)) && $value < 0) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The adjustment can\'t be -ve if the item has 0 quantity.';
    }
}
