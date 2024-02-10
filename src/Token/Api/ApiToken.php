<?php

declare(strict_types=1);

namespace MarcHagen\AhaIo\Rest\Token\Api;

readonly class ApiToken implements \Stringable
{
    public function __construct(
        protected string $apiToken
    ) {}

    public function __toString(): string
    {
        return $this->apiToken;
    }

    public function getToken(): string
    {
        return $this->apiToken;
    }
}
