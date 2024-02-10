<?php

declare(strict_types=1);

namespace MarcHagen\AhaIo\Rest\HttpClient;

use MarcHagen\AhaIo\Rest\AhaConfig;
use MarcHagen\AhaIo\Rest\Exception\InvalidArgumentException;
use MarcHagen\AhaIo\Rest\Token\Api\ApiToken;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

final class HttpClient
{
    private ResponseInterface $lastResponse;
    private RequestInterface $lastRequest;

    /**
     * @param array{api_token: ApiToken, company_name: string, base_uri: string} $options
     */
    public function __construct(
        private readonly array $options,
        private readonly ClientInterface $client,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly StreamFactoryInterface $streamFactory,
        private readonly UriFactoryInterface $uriFactory,
    ) {}

    /**
     * @param string[]              $parameters
     * @param array<string, string> $headers
     * @param ?string               $body
     *
     * @throws ClientExceptionInterface
     */
    public function send(string $path, string $method, array $parameters = [], array $headers = [], ?string $body = null): ResponseInterface
    {
        $request = $this->createRequest(
            $path,
            $method,
            $parameters,
            $headers,
            $body
        );

        $this->lastResponse = $this->client->sendRequest($request);

        return $this->lastResponse;
    }

    public function getPsr17RequestFactory(): RequestFactoryInterface
    {
        return $this->requestFactory;
    }

    public function getPsr17UriFactory(): UriFactoryInterface
    {
        return $this->uriFactory;
    }

    public function getPsr17StreamFactory(): StreamFactoryInterface
    {
        return $this->streamFactory;
    }

    public function getPsr18Client(): ClientInterface
    {
        return $this->client;
    }

    public function getPsr17ResponseFactory(): ResponseFactoryInterface
    {
        return $this->responseFactory;
    }

    public function getLastResponse(): ?ResponseInterface
    {
        return $this->lastResponse;
    }

    public function getLastRequest(): ?RequestInterface
    {
        return $this->lastRequest;
    }

    /**
     * @param string[]              $parameters
     * @param array<string, string> $headers
     * @param ?string               $body
     */
    private function createRequest(string $path, string $method, array $parameters = [], array $headers = [], ?string $body = null): RequestInterface
    {
        $uri = sprintf('%s/%s', $this->options['base_uri'], $path);

        if (count($parameters) > 0) {
            ksort($parameters);
            $uri = sprintf('%s/%s?%s', $this->options['base_uri'], $path, http_build_query($parameters));
        }

        $request = $this->getPsr17RequestFactory()->createRequest(
            $method,
            $this->getPsr17UriFactory()->createUri($uri)
        );

        if (count($headers) > 0) {
            ksort($headers);
        }

        foreach ($headers as $key => $value) {
            $request = $request->withHeader($key, $value);
        }

        foreach (AhaConfig::MANDATORY_HEADERS as $header => $value) {
            $request = $request->withHeader($header, $value);
        }

        $request = $request->withHeader('Authorization', (string) $this->options['api_token']);

        if (is_string($body)) {
            if (in_array($method, $this->getHttpMethodsWithoutBody(), true)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Trying to create a request with body with invalid method "%s", it should not contain a body.',
                        $method
                    )
                );
            }

            $stream = $this->getPsr17StreamFactory()->createStream($body);
            $request = $request->withBody($stream);
        }

        return $this->lastRequest = $request;
    }

    /**
     * @return string[]
     */
    private function getHttpMethodsWithoutBody(): array
    {
        return [
            'GET',
            'DELETE',
            'TRACE',
            'OPTIONS',
            'HEAD',
        ];
    }
}
