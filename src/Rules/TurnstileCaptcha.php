<?php

namespace romanzipp\Turnstile\Rules;

use Illuminate\Contracts\Validation\Rule;
use romanzipp\Turnstile\Validator;

class TurnstileCaptcha implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $checker = new Validator();

        return $checker->isValid($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The given :attribute is not allowed.';
    }
}
