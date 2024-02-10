<?php

declare(strict_types=1);

namespace MarcHagen\AhaIo\Rest\Api;

use JsonException;
use MarcHagen\AhaIo\Rest\Client\Client;
use MarcHagen\AhaIo\Rest\Exception\UnexpectedResponseException;
use MarcHagen\AhaIo\Rest\HttpClient\HttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

abstract class AbstractApi implements ApiInterface
{
    public function __construct(
        protected Client $client
    ) {}

    /**
     * @param string[] $parameters
     * @param array<string, string> $headers
     */
    public function get(string $path, array $parameters = [], array $headers = []): array
    {
        return $this->decodeResponse(
            $this->getHttpClient()->send($path, 'GET', $parameters, $headers)
        );
    }

    public function getHttpClient(): HttpClient
    {
        return $this->client->getHttpClient();
    }

    /**
     * @param string[] $parameters
     * @param array<string, string> $headers
     */
    public function post(string $path, ?string $postBody = null, array $parameters = [], array $headers = []): array
    {
        return $this->decodeResponse(
            $this->getHttpClient()->send($path, 'POST', $parameters, $headers, $postBody)
        );
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    private function decodeResponse(ResponseInterface $response): array
    {
        try {
            // @phpstan-ignore-next-line
            return json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new UnexpectedResponseException(
                sprintf(
                    'Unable to decode response with body "%s", %s.',
                    $response->getBody(),
                    json_last_error_msg()
                ),
                $response->getStatusCode(),
                $e
            );
        }
    }
}
