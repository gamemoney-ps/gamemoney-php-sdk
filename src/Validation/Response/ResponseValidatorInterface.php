<?php
namespace Gamemoney\Validation\Response;

interface ResponseValidatorInterface
{
    public function validate($response, $request);
}