<?php

namespace Gamemoney\Exception;

use Exception;

/**
 * RequestValidationException represents an exception caused by a validation error of request data
 * @package Gamemoney\Exception
 */
class RequestValidationException extends Exception implements GameMoneyExceptionInterface
{
    /** @var array<mixed> */
    private array $errors = [];

    /**
     * @param array<mixed> $errors
     */
    public function addErrors(string $field, array $errors): self
    {
        $this->errors[$field] = $errors;

        return $this;
    }

    /**
     * @param array<mixed> $errors
     */
    public function setErrors(array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
