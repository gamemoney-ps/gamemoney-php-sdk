<?php
namespace Gamemoney;

/**
 * Class Config
 * Contains configuration options for the Gateway
 * @package Gamemoney
 */
class Config
{
    const API_URL = 'https://paygate.gamemoney.com';

    /** @var int */
    private $project;

    /** @var string */
    private $hmac;

    /** @var string|null */
    private $privateKey;

    /** @var string */
    private $privateKeyPassword;

    /**
     * Config constructor
     * @param int $project
     * @param string $hmac
     * @param string|null $privateKey
     * @param string|null $privateKeyPassword
     */
    public function __construct($project, $hmac, $privateKey = null, $privateKeyPassword = null)
    {
        $this->project = $project;
        $this->hmac = $hmac;
        $this->privateKey = $privateKey;
        $this->privateKeyPassword = $privateKeyPassword ?: '';
    }

    /**
     * @return int
     */
    public function project()
    {
        return $this->project;
    }

    /**
     * @return string
     */
    public function hmac()
    {
        return $this->hmac;
    }

    /**
     * @return string|null
     */
    public function privateKey()
    {
        return $this->privateKey;
    }

    /**
     * @return string
     */
    public function privateKeyPassword()
    {
        return $this->privateKeyPassword;
    }

    /**
     * @return string
     */
    public function apiUrl()
    {
        return self::API_URL;
    }

    /**
     * @return string
     */
    public function gmCertificate()
    {
        return 'file://' . __DIR__ . '/../crt/gm.crt';
    }
}
