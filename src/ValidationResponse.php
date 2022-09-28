<?php

namespace romanzipp\Turnstile;

class ValidationResponse
{
    public bool $valid;

    /**
     * @var string[]
     */
    public array $errors;

    /**
     * @param bool $valid
     * @param string[] $errors
     */
    public function __construct(bool $valid, array $errors = [])
    {
        $this->valid = $valid;
        $this->errors = $errors;
    }

    public function getMessage(): string
    {
        if (empty($this->errors)) {
            return 'Unknown error';
        }

        $errors = [];

        foreach ($this->errors as $error) {
            switch ($error) {
                case 'missing-input-secret':
                    $errors[] = 'The secret parameter was not passed.';
                    break;
                case 'invalid-input-secret':
                    $errors[] = 'The secret parameter was invalid or did not exist.';
                    break;
                case 'missing-input-response':
                    $errors[] = 'The response parameter was not passed.';
                    break;
                case 'invalid-input-response':
                    $errors[] = 'The response parameter is invalid or has expired.';
                    break;
                case 'bad-request':
                    $errors[] = 'The request was rejected because it was malformed.';
                    break;
                case 'timeout-or-duplicate':
                    $errors[] = 'The response parameter has already been validated before.';
                    break;
                case 'internal-error':
                    $errors[] = 'An internal error happened while validating the response. The request can be retried.';
                    break;
            }
        }

        if (empty($errors)) {
            return 'Unknown error';
        }

        return implode(', ', $errors);
    }
}
