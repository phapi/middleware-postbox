<?php


namespace Phapi\Middleware\PostBox;

use Phapi\Contract\Di\Container;
use Phapi\Contract\Middleware\Middleware;
use Phapi\Exception\InternalServerError;
use Phapi\Exception\UnsupportedMediaType;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Postbox
 *
 * @category Phapi
 * @package  Phapi\Middleware\PostBox
 * @author   Peter Ahinko <peter@ahinko.se>
 * @license  MIT (http://opensource.org/licenses/MIT)
 * @link     https://github.com/phapi/middleware-postbox
 */
class PostBox implements Middleware
{

    /**
     * Dependency injection container
     *
     * @var Container
     */
    private $container;

    /**
     * Set dependency injection container
     *
     * @param Container $container
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Invoking the middleware
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface $response
     * @throws InternalServerError
     * @throws UnsupportedMediaType
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        // Make sure we have deserializers
        if (!isset($this->container['contentTypes'])) {
            throw new InternalServerError('No serializers seems to be configured');
        }

        // Make sure we have a content type header to work with
        if ($request->hasHeader('Content-Type')) {
            // Get the content of the header
            $header = $request->getHeaderLine('Content-Type');

            // Make sure the header value isn't empty
            if (!empty($header)) {
                // Get priorities
                $supported = $this->container['contentTypes'];
                
                // Remove included parts that aren't part of the RFC
                $header = preg_replace('/(;[a-z]*=[a-z0-9\-]*)/i', '', $header);
                // Replace the original header value
                $request = $request->withHeader('Content-Type', $header);

                // Check if the content type is supported
                if (!in_array($header, $supported)) {
                    // The content type isn't supported
                    throw new UnsupportedMediaType(
                        'Can not handle the supplied content type. Supported types are ' . implode(', ', $supported)
                    );
                }
            }
        }

        // Call next middleware
        return $next($request, $response, $next);
    }
}
