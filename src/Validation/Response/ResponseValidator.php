<?php

namespace Gamemoney\Validation\Response;

use Gamemoney\Exception\ResponseValidationException;
use Gamemoney\Sign\SignatureVerifierInterface;

/**
 * @package Gamemoney\Validation\Response\Validator
 */
class ResponseValidator implements ResponseValidatorInterface
{
    private SignatureVerifierInterface $signatureVerifier;

    public function __construct(SignatureVerifierInterface $signatureVerifier)
    {
        $this->signatureVerifier = $signatureVerifier;
    }

    /**
     * @inheritDoc
     */
    public function validate(array $response, array $request): void
    {
        if (!$this->signatureVerifier->verify($response)) {
            throw new ResponseValidationException('Signature mismatch');
        }

        if (isset($request['rand']) && $request['rand'] !== $response['rand']) {
            throw new ResponseValidationException('Wrong rand parameter: ' . $response['rand']);
        }
    }
}
