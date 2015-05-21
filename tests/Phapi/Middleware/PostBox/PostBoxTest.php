<?php

namespace Phapi\Tests\ContentNegotiation;

use Phapi\Middleware\PostBox\PostBox;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @coversDefaultClass \Phapi\Middleware\Postbox\PostBox
 */
class PostOfficeTest extends TestCase
{

    public function testInvoke()
    {
        $container = \Mockery::mock('Phapi\Contract\Di\Container');
        $container->shouldReceive('offsetExists')->with('contentTypes')->andReturn(true);
        $container->shouldReceive('offsetGet')->with('contentTypes')->andReturn(['application/json', 'text/json']);

        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('hasHeader')->with('Content-Type')->andReturn(true);
        $request->shouldReceive('getHeaderLine')->with('Content-Type')->andReturn('application/json');

        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $middleware = new PostBox();
        $middleware->setContainer($container);

        $middleware(
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        );
    }

    public function testInvokeNoSerializersException()
    {
        $container = \Mockery::mock('Phapi\Contract\Di\Container');
        $container->shouldReceive('offsetExists')->with('contentTypes')->andReturn(false);

        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('hasHeader')->with('Content-Type')->andReturn(true);
        $request->shouldReceive('getHeaderLine')->with('Content-Type')->andReturn('application/json');

        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $middleware = new PostBox();
        $middleware->setContainer($container);

        $this->setExpectedException('Phapi\Exception\InternalServerError', 'No serializers seems to be configured');
        $middleware(
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        );
    }

    public function testInvokeUnsupportedMediaTypeException()
    {
        $container = \Mockery::mock('Phapi\Contract\Di\Container');
        $container->shouldReceive('offsetExists')->with('contentTypes')->andReturn(true);
        $container->shouldReceive('offsetGet')->with('contentTypes')->andReturn(['application/json', 'text/json']);

        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('hasHeader')->with('Content-Type')->andReturn(true);
        $request->shouldReceive('getHeaderLine')->with('Content-Type')->andReturn('audio/mp3');

        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $middleware = new PostBox();
        $middleware->setContainer($container);

        $this->setExpectedException('Phapi\Exception\UnsupportedMediaType', 'Can not handle the supplied content type. Supported types are');
        $middleware(
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        );
    }
}
