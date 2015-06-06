# Postbox Middleware
The Postbox middleware has one simple task; take the Content-Type header from the request and check if there is a Deserializer that supports the mime type. If the mime type isn't supported an <code>415 UnsupportedMediaType</code> exception will be thrown.

## Installation
This middleware is by default included in the [Phapi Framework](https://github.com/phapi/phapi) but if you need to install it it's available to install via [Packagist](https://packagist.org) and [Composer](https://getcomposer.org).

```shell
$ php composer.phar require phapi/middleware-postbox:1.*
```

## Phapi
This middleware is a Phapi package used by the [Phapi Framework](https://github.com/phapi/phapi). The middleware are also [PSR-7](https://github.com/php-fig/http-message) compliant and implements the [Phapi Middleware Contract](https://github.com/phapi/contract).

## License
Postbox Middleware is licensed under the MIT License - see the [license.md](https://github.com/phapi/middleware-postbox/blob/master/license.md) file for details

## Contribute
Contribution, bug fixes etc are [always welcome](https://github.com/phapi/middleware-postbox/issues/new).
