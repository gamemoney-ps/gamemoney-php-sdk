<?php

namespace Gamemoney\Validation\Response;

use Gamemoney\Exception\ResponseValidationException;

/**
 * @package Gamemoney\Validation\Response
 */
interface ResponseValidatorInterface
{
    /**
     * @param array<mixed> $response
     * @param array<mixed> $request
     * @throws ResponseValidationException
     */
    public function validate(array $response, array $request): void;
}
