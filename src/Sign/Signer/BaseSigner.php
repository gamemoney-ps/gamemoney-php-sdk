<?php
namespace Gamemoney\Sign\Signer;

use Gamemoney\Sign\SignerInterface;

abstract class BaseSigner implements SignerInterface
{
    /**
     * @inheritdoc
     */
    protected function arrayToString(array $data)
    {
        $text = "";
        ksort($data);
        foreach ($data as $key => $value)
        {
            if (is_array($value)) {
                $value = $this->arrayToString($value);
            }
            $text .= $key.":".$value.";";
        }
        return $text;
    }
}