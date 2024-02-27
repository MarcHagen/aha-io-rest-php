<?php

declare(strict_types=1);

namespace MarcHagen\AhaIo\Rest\Client;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use MarcHagen\AhaIo\Rest\AhaConfig;
use MarcHagen\AhaIo\Rest\ApiMethodsTrait;
use MarcHagen\AhaIo\Rest\ConfigurationInterface;
use MarcHagen\AhaIo\Rest\Exception\AhaIoApiException;
use MarcHagen\AhaIo\Rest\HttpClient\HttpClient;
use MarcHagen\AhaIo\Rest\Token\Api\ApiToken;
use MarcHagen\AhaIo\Rest\Token\Api\BearerToken;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Throwable;

final class Client
{
    use ApiMethodsTrait;

    /** @var array{api_token: BearerToken|ApiToken, company_name: string, base_uri: string} */
    private array $options;
    private HttpClient $httpClient;

    /**
     * @param ConfigurationInterface|array<string, mixed> $options
     * @param ?ClientInterface $http - PSR18 ClientInterface - https://www.php-fig.org/psr/psr-18/
     * @param ?RequestFactoryInterface $requestFactory - PSR17 RequestFactoryInterface - https://www.php-fig.org/psr/psr-17/#21-requestfactoryinterface
     * @param ?ResponseFactoryInterface $responseFactory - PSR17 ResponseFactoryInterface - https://www.php-fig.org/psr/psr-17/#22-responsefactoryinterface
     * @param ?StreamFactoryInterface $streamFactory - PSR17 StreamFactoryInterface - https://www.php-fig.org/psr/psr-17/#24-streamfactoryinterface
     * @param ?UriFactoryInterface $uriFactory - PSR17 UriFactoryInterface - https://www.php-fig.org/psr/psr-17/#26-urifactoryinterface
     */
    public function __construct(
        ConfigurationInterface|array $options = [],
        ?ClientInterface $http = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?ResponseFactoryInterface $responseFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
        ?UriFactoryInterface $uriFactory = null
    ) {
        if ($options instanceof ConfigurationInterface) {
            $options = $options->all();
        }

        $this->configureOptions($options);

        try {
            $this->setClientHandler($http, $requestFactory, $responseFactory, $streamFactory, $uriFactory);
        } catch (Throwable $e) {
            throw new AhaIoApiException('Failed to initialize client: ' . $e->getMessage(), 0, $e);
        }
    }

    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * @return array{api_token: BearerToken|ApiToken, company_name: string, base_uri: string}
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function getOption(string $key): mixed
    {
        return array_key_exists($key, $this->options) ? $this->options[$key] : null;
    }

    public function getToken(): BearerToken|ApiToken
    {
        return $this->options['api_token'];
    }

    /**
     * @param array<string, mixed> $options
     */
    private function configureOptions(array $options): void
    {
        $resolver = new OptionsResolver();

        $resolver->setDefaults(
            [
                'company_name' => null,
                'api_token' => null,
            ]
        );

        $resolver->setRequired(
            [
                'company_name',
                'api_token',
            ]
        );

        $resolver->setAllowedTypes('company_name', ['string']);
        $resolver->setAllowedTypes('api_token', [ApiToken::class, BearerToken::class]);

        if (array_key_exists('api_token', $options) && is_string($options['api_token'])) {
            $options['api_token'] = new ApiToken($options['api_token']);
        }

        $this->options = $this->postResolve(
            $resolver->resolve($options)
        );
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return array{api_token: BearerToken|ApiToken, company_name: string, base_uri: string}
     */
    private function postResolve(array $options = []): array
    {
        //@phpstan-ignore-next-line
        return [
            'company_name' => $options['company_name'],
            'api_token' => $options['api_token'],
            //@phpstan-ignore-next-line
            'base_uri' => vsprintf(AhaConfig::getBaseURI(), [$options['company_name']]),
        ];
    }

    private function setClientHandler(
        ?ClientInterface $http = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?ResponseFactoryInterface $responseFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
        ?UriFactoryInterface $uriFactory = null
    ): void {
        $this->httpClient = new HttpClient(
            $this->options,
            $http ?? Psr18ClientDiscovery::find(),
            $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory(),
            $responseFactory ?? Psr17FactoryDiscovery::findResponseFactory(),
            $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory(),
            $uriFactory ?? Psr17FactoryDiscovery::findUriFactory(),
        );
    }
}
