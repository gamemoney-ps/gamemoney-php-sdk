<?php

namespace Gamemoney\Request;

/**
 * @package Gamemoney\Request
 */
final class Request implements RequestInterface
{
    private string $action;

    /** @var array<mixed> */
    private array $data;

    /**
     * @param string $action URI
     * @param array<mixed> $data request data array
     */
    public function __construct(string $action, array $data = [])
    {
        $this->action = $action;
        $this->data = $data;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function setField(string $field, mixed $value): self
    {
        $this->data[$field] = $value;
        return $this;
    }

    public function getField(string $field): mixed
    {
        return $this->data[$field];
    }
}
