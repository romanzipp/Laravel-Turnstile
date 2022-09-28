<?php

namespace romanzipp\Turnstile;

class ValidationResponse
{
    public bool $valid;

    public function __construct(bool $valid)
    {
        $this->valid = $valid;
    }

    public function getMessage(): string
    {
        return '??';
    }
}
