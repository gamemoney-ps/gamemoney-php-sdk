<?php
namespace Gamemoney\Sign;

/**
 * Interface SignerInterface
 * @package Gamemoney\Sign
 */
interface SignerInterface
{
    /**
     * Sygn sending data
     * @param  array  $data
     * @return String
     */
    public function getSignature(array $data);
}