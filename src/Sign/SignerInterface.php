<?php
namespace Gamemoney\Sign;

/**
 * Interface SignerInterface
 * @package Gamemoney\Sign
 */
interface SignerInterface
{
    /**
     * Sign sending data
     * @param array $data
     * @return string
     */
    public function getSignature(array $data);
}
