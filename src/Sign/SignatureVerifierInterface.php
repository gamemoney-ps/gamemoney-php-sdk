<?php

namespace Gamemoney\Sign;

interface SignatureVerifierInterface
{
    /**
     * @param array<mixed> $data
     */
    public function verify(array $data): bool;
}
