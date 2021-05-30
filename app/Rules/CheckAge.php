<?php

namespace App\Rules;

use DateTime;
use Illuminate\Contracts\Validation\Rule;

class CheckAge implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $today = new DateTime(date('m/d/Y'));
        $birthday  = new DateTime($value);

        $diff = $birthday->diff($today);
        $minyear = 14;

        if($diff->y >=$minyear){
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Age must be at least 14 years old.';
    }
}
