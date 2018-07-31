<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Middleware;

use GuzzleHttp\Psr7\ServerRequest;
use Narrowspark\TestingHelper\Middleware\CallableMiddleware;
use Narrowspark\TestingHelper\Middleware\RequestHandlerMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseFactoryInterface;

class CallableMiddlewareTest extends TestCase
{
    /**
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage The value returned must be "scalar" or an object with "__toString" method.
     */
    public function testMiddlewareThrowErrorOnScalarType(): void
    {
        $middleware = new CallableMiddleware(
            function () {
                return new class() {
                };
            },
            \Mockery::mock(ResponseFactoryInterface::class)
        );

        $middleware->process(
            new ServerRequest('GET', '/'),
            new RequestHandlerMiddleware(function (): void {
            })
        );
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage No ResponseFactory class found.
     */
    public function testConstructorThrowErrorOnWrongResponseFactory2(): void
    {
        $middleware = new CallableMiddleware(
            function () {
                return '';
            }
        );

        $middleware->process(
            new ServerRequest('GET', '/'),
            new RequestHandlerMiddleware(function (): void {
            })
        );
    }
}
