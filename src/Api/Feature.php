<?php

declare(strict_types=1);

namespace MarcHagen\AhaIo\Rest\Api;

final class Feature extends AbstractApi
{
    public function getFeatures(array $parameters = []): array
    {
        return $this->get('features', $parameters);
    }
}
