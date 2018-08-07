<?php
namespace Gamemoney\Validation\Response;

use Gamemoney\Exception\ResponseValidationException;
use Gamemoney\Sign\SignatureVerifierInterface;

class ResponseValidator implements ResponseValidatorInterface
{
    /** @var SignatureVerifierInterface */
    private $signatureVerifier;

    public function __construct(SignatureVerifierInterface $signatureVerifier)
    {
        $this->signatureVerifier = $signatureVerifier;
    }

    /**
     * @param $response
     * @param $request
     * @throws ResponseValidationException
     */
    public function validate($response, $request)
    {
        if(!$this->signatureVerifier->verify($response)) {
            throw new ResponseValidationException('Signature mismatch');
        }

        if(isset($request['rand']) && $request['rand'] != $response['rand']) {
            throw new ResponseValidationException('Wrong rand parameter: ' . $response['rand']);
        }
    }
}