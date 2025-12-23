<?php

namespace Gamemoney;

/**
 * Contains configuration options for the Gateway.
 */
class Config
{
    private string $apiUrl;

    private int $project;

    private string $hmac;

    private string $certificate;

    private ?string $privateKey;

    private ?string $privateKeyPassword;

    public function __construct(
        string $apiUrl,
        int $project,
        string $hmac,
        string $certificate,
        ?string $privateKey = null,
        ?string $privateKeyPassword = null,
    ) {
        $this->apiUrl = $apiUrl;
        $this->project = $project;
        $this->hmac = $hmac;
        $this->certificate = $certificate;
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
        return $this->apiUrl;
    }

    public function getCertificate(): string
    {
        return $this->certificate;
    }
}
