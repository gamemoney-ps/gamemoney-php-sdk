<?php

namespace Gamemoney\Validation\Request;

use Symfony\Component\Validator\Validation;
use Gamemoney\Exception\RequestValidationException;

/**
 * @package Gamemoney\Validation\Request
 */
final class RequestValidator implements RequestValidatorInterface
{
    /**
     * @inheritDoc
     */
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
