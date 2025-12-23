<?php

namespace Gamemoney\Request;

final class Request implements RequestInterface
{
    private string $action;

    /** @var array<mixed> */
    private array $data;

    /**
     * @param array<mixed> $data
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

    public function getData(): array
    {
        return $this->data;
    }

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
