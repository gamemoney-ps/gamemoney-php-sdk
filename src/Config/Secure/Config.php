<?php

namespace Gamemoney\Config\Secure;

/**
 * Class Config
 * Contains configuration options for the Gateway
 * @package Gamemoney
 */
class Config
{
    const API_URL = 'https://secure.gamemoney.com/api';

    /**
     * @return string
     */
    public function apiUrl()
    {
        return self::API_URL;
    }
}
