<?php
namespace Gamemoney\Validation\Response;

use Gamemoney\Exception\ResponseValidationException;

/**
 * Interface ResponseValidatorInterface
 * @package Gamemoney\Validation\Response
 */
interface ResponseValidatorInterface
{
    /**
     * @param array $response
     * @param array $request
     * @throws ResponseValidationException
     */
    public function validate(array $response, array $request);
}
