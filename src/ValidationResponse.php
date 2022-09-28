<?php

namespace romanzipp\Turnstile;

class ValidationResponse
{
    public bool $valid;

    public array $errors;

    public function __construct(bool $valid, array $errors)
    {
        $this->valid = $valid;
        $this->errors = $errors;
    }

    public function getMessage(): string
    {
        if (empty($this->errors)) {
            return 'Unknown error';
        }

        switch ($this->errors) {
            case 'missing-input-secret':
                return 'The secret parameter was not passed.';
            case 'invalid-input-secret':
                return 'The secret parameter was invalid or did not exist.';
            case 'missing-input-response':
                return 'The response parameter was not passed.';
            case 'invalid-input-response':
                return 'The response parameter is invalid or has expired.';
            case 'bad-request':
                return 'The request was rejected because it was malformed.';
            case 'timeout-or-duplicate':
                return 'The response parameter has already been validated before.';
            case 'internal-error':
                return 'An internal error happened while validating the response. The request can be retried.';
        }

        return 'Unknown error';
    }
}
