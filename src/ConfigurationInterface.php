<?php

declare(strict_types=1);

namespace MarcHagen\AhaIo\Rest;

interface ConfigurationInterface
{
    /**
     * @return array<string, mixed>
     */
    public function all(): array;
}
