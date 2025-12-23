<?php

namespace Gamemoney\Validation\Request;

use Gamemoney\Exception\RequestValidationException;
use Symfony\Component\Validator\Validation;

final class RequestValidator implements RequestValidatorInterface
{
    public function validate(array $rules, array $data): void
    {
        $validator = Validation::createValidator();
        $errors = [];

        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? null;
            $violations = $validator->validate($value, $rule);

            foreach ($violations as $violation) {
                $errors[$field] = $violation->getMessage();
            }
        }

        if (!empty($errors)) {
            $exception = new RequestValidationException('Bad request parameters');
            $exception->setErrors($errors);

            throw $exception;
        }
    }
}
