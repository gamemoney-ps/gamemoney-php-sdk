<?php
namespace Gamemoney\Sign;

interface SignatureVerifierInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function verify(array $data);
}