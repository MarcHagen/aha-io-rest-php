# PHP Aha.io REST

## Introduction

Aha.io REST API PHP Client uses [PSR-7 (HTTP Message Interface)](http://www.php-fig.org/psr/psr-7/) to connect
with [JetBrains YouTrack REST API](https://www.jetbrains.com/help/youtrack/standalone/2017.2/Resources-for-Developers.html).

## Contents

- [Features](#features)
- [PSR Compliance](#psr-compliance)
- [Dependencies you have to fulfill yourself](#dependencies-you-have-to-fulfill-yourself)

## Features

- Framework-agnostic.
- Following PHP Standard Recommendations (PSR):
  - [PSR-4 (Autoloading Standard)](http://www.php-fig.org/psr/psr-4/).
  - [PSR-12 (Extended Coding Style)](http://www.php-fig.org/psr/psr-12/).
  - Others see [PSR Compliance](#psr-compliance)
- Covered with unit tests.

## PSR Compliance

- [PSR-7: HTTP Message Interface](http://www.php-fig.org/psr/psr-7/)
  - Requests and responses will be modified via relevant event listeners.
- [PSR-17: HTTP Factories](http://www.php-fig.org/psr/psr-17/)
  - Bring along the http factories of your choice.
- [PSR-18: HTTP Client](http://www.php-fig.org/psr/psr-18/)
  - Bring along the PSR-18 http client of your choice.

## Dependencies you have to fulfill yourself

- For `PSR-7: HTTP Message Interface`, for example `nyholm/psr7`.
- For `PSR-17: HTTP Factories`, for example `nyholm/psr7`.
- For `PSR-18: HTTP Client`, for example `guzzlehttp/guzzle`.  

## Install `marchagen/aha-io-rest-php`
If the required dependencies above are met, you are ready to install the library.

```
composer require marchagen/aha-io-rest-php:^1
```
Include Composer's autoloader:

```php
require_once __DIR__ . '/../vendor/autoload.php';
```
