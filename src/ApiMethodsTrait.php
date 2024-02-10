<?php

declare(strict_types=1);

namespace MarcHagen\AhaIo\Rest;

trait ApiMethodsTrait
{
    public function getFeatureApi(): Api\Feature
    {
        return new Api\Feature($this);
    }
}
