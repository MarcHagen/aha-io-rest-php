<?php

declare(strict_types=1);

namespace MarcHagen\AhaIo\Rest\Exception;

use Psr\Http\Client\ClientExceptionInterface;

final class UnexpectedResponseException extends RuntimeException implements ClientExceptionInterface
{
}
