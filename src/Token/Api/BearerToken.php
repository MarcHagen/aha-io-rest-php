<?php

declare(strict_types=1);

namespace MarcHagen\AhaIo\Rest\Token\Api;

readonly class BearerToken extends ApiToken implements \Stringable
{
    public function __toString(): string
    {
        return 'Bearer ' . $this->apiToken;
    }
}
