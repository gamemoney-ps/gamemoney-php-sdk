<?php
namespace Gamemoney\Exception;

/**
 * Class RequestValidationException
 * RequestValidationException represents an exception caused by a validation error of request data
 * @package Gamemoney\Exception
 */
class RequestValidationException extends \Exception implements GamemoneyExceptionInterface
{
    /** @var array */
    private $errors = [];

    /**
     * @param string $field
     * @param array $errors
     * @return self
     */
    public function addErrors($field, array $errors)
    {
        $this->errors[$field] = $errors;

        return $this;
    }

    /**
     * @param array $errors
     * @return self
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
