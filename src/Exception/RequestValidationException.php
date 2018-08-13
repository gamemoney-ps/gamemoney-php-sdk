<?php
namespace Gamemoney\Exception;

/**
 * Class RequestValidationException
 * RequestValidationException represents an exception caused by a validation error of request data
 * @package Gamemoney\Exception
 */
class RequestValidationException extends \Exception implements GamemoneyExceptionInterface
{
    private $errors = [];

    public function addErrors($field, $errors)
    {
        $this->errors[$field] = $errors;
        return $this;
    }

    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}