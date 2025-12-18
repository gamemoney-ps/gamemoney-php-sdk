<?php

namespace Gamemoney\Validation\Response\Validator;

use Gamemoney\Validation\Response\ResponseValidatorInterface;

class ResponseValidatorSecure implements ResponseValidatorInterface
{
    /**
     * @inheritDoc
     */
    public function validate(array $response, array $request): void
    {
    }
}
