<?php

declare(strict_types=1);

/**
 * This file is part of Narrowspark Framework.
 *
 * (c) Daniel Bannert <d.bannert@anolilab.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Narrowspark\TestingHelper\Tests\Middleware;

use GuzzleHttp\Psr7\ServerRequest;
use Narrowspark\TestingHelper\Middleware\CallableMiddleware;
use Narrowspark\TestingHelper\Middleware\RequestHandlerMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseFactoryInterface;

/**
 * @internal
 *
 * @small
 */
final class CallableMiddlewareTest extends TestCase
{
    public function testMiddlewareThrowErrorOnScalarType(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('The value returned must be "scalar" or an object with "__toString" method.');

        $middleware = new CallableMiddleware(
            static function () {
                return new class() {
                };
            },
            \Mockery::mock(ResponseFactoryInterface::class)
        );

        $middleware->process(
            new ServerRequest('GET', '/'),
            new RequestHandlerMiddleware(static function (): void {
            })
        );
    }

    public function testConstructorThrowErrorOnWrongResponseFactory2(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No ResponseFactory class found.');

        $middleware = new CallableMiddleware(
            static function () {
                return '';
            }
        );

        $middleware->process(
            new ServerRequest('GET', '/'),
            new RequestHandlerMiddleware(static function (): void {
            })
        );
    }
}
