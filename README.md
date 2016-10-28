# Qivivo Provider for OAuth 2.0 Client

[![Latest Version](https://img.shields.io/github/release/bpolaszek/oauth2-qivivo.svg?style=flat-square)](https://github.com/bpolaszek/oauth2-qivivo/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/bpolaszek/oauth2-qivivo/master.svg?style=flat-square)](https://travis-ci.org/bpolaszek/oauth2-qivivo)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/bpolaszek/oauth2-qivivo.svg?style=flat-square)](https://scrutinizer-ci.com/g/bpolaszek/oauth2-qivivo/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/bpolaszek/oauth2-qivivo.svg?style=flat-square)](https://scrutinizer-ci.com/g/bpolaszek/oauth2-qivivo)
[![Total Downloads](https://img.shields.io/packagist/dt/bpolaszek/oauth2-qivivo.svg?style=flat-square)](https://packagist.org/packages/bentools/oauth2-qivivo)

This package provides Qivivo OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use composer:

```
composer require bentools/oauth2-qivivo
```

## Usage

Usage is the same as The League's OAuth client, using `\BenTools\Qivivo\OAuth2\Provider\Qivivo` as the provider.

### Authorization Code Flow

```php
$provider = new BenTools\Qivivo\OAuth2\Provider\Qivivo([
    'clientId'          => '{qivivo-client-id}',
    'clientSecret'      => '{qivivo-client-secret}',
    'redirectUri'       => 'https://example.com/callback-url'
]);
```
For further usage of this package please refer to the [core package documentation on "Authorization Code Grant"](https://github.com/thephpleague/oauth2-client#usage).

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/bpolaszek/oauth2-qivivo/blob/master/CONTRIBUTING.md) for details.


## Credits

- [Benoit POLASZEK](https://github.com/bpolaszek)
- [Steven Maguire](https://github.com/stevenmaguire/oauth2-nest) (NEST provider)


## License

The MIT License (MIT). Please see [License File](https://github.com/bpolaszek/oauth2-qivivo/blob/master/LICENSE) for more information.
