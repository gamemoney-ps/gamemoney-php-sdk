<?php
namespace Gamemoney\Validation\Response;

use Gamemoney\Exception\ResponseValidationException;
use Gamemoney\Sign\SignatureVerifierInterface;

/**
 * Class ResponseValidator
 * @package Gamemoney\Validation\Response
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
        if (! $this->signatureVerifier->verify($response)) {
            throw new ResponseValidationException('Signature mismatch');
        }

        if (isset($request['rand']) && $request['rand'] !== $response['rand']) {
            throw new ResponseValidationException('Wrong rand parameter: ' . $response['rand']);
        }
    }
}
