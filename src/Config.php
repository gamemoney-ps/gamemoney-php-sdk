<?php

namespace Gamemoney;

/**
 * Contains configuration options for the Gateway
 * @package Gamemoney
 */
class Config
{
    const API_URL = 'https://paygate.gamemoney.com';

    const SECURE_URL = 'https://secure.gamemoney.com/api/';

    private int $project;

    private string $hmac;

    private ?string $privateKey;

    private ?string $privateKeyPassword;

    public function __construct(
        int $project,
        string $hmac,
        ?string $privateKey = null,
        ?string $privateKeyPassword = null,
    ) {
        $this->project = $project;
        $this->hmac = $hmac;
        $this->privateKey = $privateKey;
        $this->privateKeyPassword = $privateKeyPassword;
    }

    public function project(): int
    {
        return $this->project;
    }

    public function hmac(): string
    {
        return $this->hmac;
    }

    public function privateKey(): ?string
    {
        return $this->privateKey;
    }

    public function privateKeyPassword(): ?string
    {
        return $this->privateKeyPassword;
    }

    public function apiUrl(): string
    {
        return self::API_URL;
    }

    public function secureUrl(): string
    {
        return self::SECURE_URL;
    }

    public function gmCertificate(): string
    {
        return 'file://' . __DIR__ . '/../crt/gm.crt';
    }
}
