<?php
namespace Gamemoney\Sign;

interface SignatureVerifierInterface
{
    /**
     * @param array $data
     * @return bool
     */
    public function verify(array $data);
}
