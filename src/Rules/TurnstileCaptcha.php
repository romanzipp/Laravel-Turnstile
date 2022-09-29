<?php

namespace romanzipp\Turnstile\Rules;

use Illuminate\Contracts\Validation\Rule;
use romanzipp\Turnstile\ValidationResponse;
use romanzipp\Turnstile\Validator;

class TurnstileCaptcha implements Rule
{
    public ValidationResponse  $response;

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->response = (new Validator())->validate($value);

        return $this->response->isValid();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->response->getMessage();
    }
}
