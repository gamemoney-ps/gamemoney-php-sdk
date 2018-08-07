<?php
namespace Gamemoney\Sign;

interface SignatureVerifierInterface
{
    public function verify(array $data);
}