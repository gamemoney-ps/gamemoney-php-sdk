<?php

namespace Gamemoney\Validation\Response\Validator;

use Gamemoney\Exception\ResponseValidationException;
use Gamemoney\Sign\SignatureVerifierInterface;
use Gamemoney\Validation\Response\ResponseValidatorInterface;

/**
 * Class ResponseValidator
 * @package Gamemoney\Validation\Response\Validator
 */
class ResponseValidator implements ResponseValidatorInterface
{
    /** @var SignatureVerifierInterface */
    private $signatureVerifier;

    /**
     * @param SignatureVerifierInterface $signatureVerifier
     */
    public function __construct(SignatureVerifierInterface $signatureVerifier)
    {
        $this->signatureVerifier = $signatureVerifier;
    }

    /**
     * @inheritdoc
     */
    public function validate(array $response, array $request)
    {
        if (!$this->signatureVerifier->verify($response)) {
            throw new ResponseValidationException('Signature mismatch');
        }

        if (isset($request['rand']) && $request['rand'] !== $response['rand']) {
            throw new ResponseValidationException('Wrong rand parameter: ' . $response['rand']);
        }
    }
}
