<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Middleware;

use Http\Factory\Guzzle\ResponseFactory;
use Http\Factory\Guzzle\ServerRequestFactory;
use Narrowspark\TestingHelper\Middleware\CallableMiddleware;
use Narrowspark\TestingHelper\Middleware\RequestHandlerMiddleware;
use PHPUnit\Framework\TestCase;

class CallableMiddlewareTest extends TestCase
{
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Class name don't implements [Interop\Http\Factory\ResponseFactoryInterface] interface; [Narrowspark\TestingHelper\Tests\Middleware\CallableMiddlewareTest] given.
     */
    public function testConstructorThrowErrorOnWrongResponseFactory(): void
    {
        new CallableMiddleware(
            function (): void {
            },
            CallableMiddlewareTest::class
        );
    }

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
            ResponseFactory::class
        );

        $middleware->process(
            (new ServerRequestFactory())->createServerRequest('GET', '/'),
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
            (new ServerRequestFactory())->createServerRequest('GET', '/'),
            new RequestHandlerMiddleware(function (): void {
            })
        );
    }
}
