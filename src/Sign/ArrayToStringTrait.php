<?php
namespace Gamemoney\Sign;

trait ArrayToStringTrait
{
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