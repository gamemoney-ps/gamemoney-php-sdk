<?php

namespace Gamemoney\Sign;

/**
 * @package Gamemoney\Sign
 */
trait ArrayToStringTrait
{
    /**
     * @param array<mixed> $data
     */
    protected function arrayToString(array $data): string
    {
        $text = '';
        ksort($data);

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = $this->arrayToString($value);
            }

            $text .= $key . ':' . $value . ';';
        }

        return $text;
    }
}
