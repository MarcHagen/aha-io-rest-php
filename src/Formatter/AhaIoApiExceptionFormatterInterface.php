<?php declare(strict_types=1);

namespace MarcHagen\AhaIo\Rest\Formatter;

use MarcHagen\AhaIo\Rest\Exception\AhaIoApiException;

interface AhaIoApiExceptionFormatterInterface
{
    /**
     * @param AhaIoApiException $exception
     * @return string
     */
    public function formatApiException(AhaIoApiException $exception): string;
}
