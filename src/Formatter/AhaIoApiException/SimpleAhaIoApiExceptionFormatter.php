<?php

declare(strict_types=1);

namespace MarcHagen\AhaIo\Rest\Formatter\AhaIoApiException;

use MarcHagen\AhaIo\Rest\Exception\AhaIoApiException;
use MarcHagen\AhaIo\Rest\Formatter\AhaIoApiExceptionFormatterInterface;

final class SimpleAhaIoApiExceptionFormatter implements AhaIoApiExceptionFormatterInterface
{
    public function formatApiException(AhaIoApiException $exception): string
    {
        return sprintf(
            '%s %s',
            $exception->getCode(),
            $exception->getMessage()
        );
    }
}
