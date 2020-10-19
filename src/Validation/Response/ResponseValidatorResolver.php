<?php

namespace Gamemoney\Validation\Response;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Sign\SignatureVerifierInterface;
use Gamemoney\Validation\Response\Validator\ResponseValidator;
use Gamemoney\Validation\Response\Validator\ResponseValidatorSecure;

class ResponseValidatorResolver implements ResponseValidatorResolverInterface
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
     * @inheritdocs
     */
    public function resolve($action)
    {
        if (preg_match(RequestInterface::STORE_ONLY_CARD_DATA_REGEX, $action)) {
            return new ResponseValidatorSecure();
        }

        return new ResponseValidator($this->signatureVerifier);
    }
}
