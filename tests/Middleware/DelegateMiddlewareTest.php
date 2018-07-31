<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Middleware;

use GuzzleHttp\Psr7\ServerRequest;
use Narrowspark\TestingHelper\Middleware\RequestHandlerMiddleware;
use Narrowspark\TestingHelper\Phpunit\MockeryTestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
final class DelegateMiddlewareTest extends MockeryTestCase
{
    public function testCallCallableWithProcess(): void
    {
        $middleware = new RequestHandlerMiddleware(function () {
            return $this->mock(ResponseInterface::class);
        });

        static::assertInstanceOf(
            ResponseInterface::class,
            $middleware->handle(new ServerRequest('GET', '/'))
        );
    }
}
