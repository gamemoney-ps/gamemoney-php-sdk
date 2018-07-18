<?php
namespace Gamemoney\Exception;

class ValidationException extends \Exception implements GamemoneyExceptionInterface
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