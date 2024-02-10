<?php

declare(strict_types=1);

namespace MarcHagen\AhaIo\Rest;

final class AhaConfig
{
    public const string VERSION = '1.0.0';
    public const string API_VERSION = 'v1';
    public const string API_URI = 'https://%s.aha.io/api/';
    public const string USERAGENT = 'AhaIoRestPHP/' . self::VERSION . '(API_VERSION: ' . self::API_VERSION . ')';

    public const array MANDATORY_HEADERS = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json; charset=utf-8',
        'User-Agent' => self::USERAGENT,
    ];

    public static function getBaseURI(): string
    {
        return self::API_URI . self::API_VERSION;
    }
}
