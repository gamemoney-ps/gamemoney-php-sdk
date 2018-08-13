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
     * @param $response
     * @param $request
     * @throws ResponseValidationException
     */
    public function validate($response, $request);
}