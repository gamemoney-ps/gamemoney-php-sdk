<?php
namespace Gamemoney\Validation\Validator;

use Symfony\Component\Validator\Validation;
use Gamemoney\Exception\ValidationException;

abstract class BaseValidator
{
    abstract protected function rules();

    public function validate(array $data)
    {
        $validator = Validation::createValidator();
        $rules = $this->rules();
        $errors = [];
        foreach($rules as $field => $rule) {
            $value = isset($data[$field]) ? $data[$field] : null;
            $violations = $validator->validate($value, $rule);

            foreach($violations as $violation) {
                $errors[$field] = $violation->getMessage();
            }
        }

        if(!empty($errors)) {
            $exception = new ValidationException('Bad request parameters');
            $exception->setErrors($errors);

            throw $exception;
        }
    }
}