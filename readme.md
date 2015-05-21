# Postbox Middleware
The Postbox middleware has one simple task; take the Content-Type header from the request and check if there is a Deserializer that supports the mime type. If the mime type isn't supported an <code>415 UnsupportedMediaType</code> exception will be thrown.

## Phapi
This middleware is a Phapi package used by the [Phapi Framework](https://github.com/phapi/phapi). The middleware are also [PSR-7](https://github.com/php-fig/http-message) compliant and implements the [Phapi Middleware Contract](https://github.com/phapi/contract).

## License
Postbox Middleware is licensed under the MIT License - see the [license.md](https://github.com/phapi/middleware-postbox/blob/master/license.md) file for details

## Contribute
Contribution, bug fixes etc are [always welcome](https://github.com/phapi/middleware-postbox/issues/new).
