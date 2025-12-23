<?php

namespace Gamemoney\Validation\Response;

use Gamemoney\Exception\ResponseValidationException;

interface ResponseValidatorInterface
{
    /**
     * @param array<mixed> $response
     * @param array<mixed> $request
     *
     * @throws ResponseValidationException
     */
    public function validate(array $response, array $request): void;
}
