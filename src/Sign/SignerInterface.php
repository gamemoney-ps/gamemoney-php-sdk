<?php
namespace Gamemoney\Sign;

interface SignerInterface
{
    /**
     * Sygn sending data
     * @param  array  $data
     * @return String
     */
    public function getSignature(array $data);

    /**
     * @param array $data
     * @return string
     */
    public  function arrayToString(array $data);
}