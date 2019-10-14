<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmailsArrayRule implements Rule
{


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $emails_array = explode(',',$value);
        foreach ($emails_array as $email){
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
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
        return trans('validation.email');
    }
}
