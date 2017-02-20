<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Middleware;

use Narrowspark\TestingHelper\Middleware\DelegateMiddleware;
use Narrowspark\TestingHelper\Traits\MockeryTrait;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Narrowspark\TestingHelper\Phpunit\MockeryTestCase;

class DelegateMiddlewareTest extends MockeryTestCase
{
    public function testCallCallableWithProcess()
    {
        $middleware = new DelegateMiddleware(function () {
            return $this->mock(ResponseInterface::class);
        });

        $this->assertInstanceOf(
            ResponseInterface::class,
            $middleware->process($this->mock(ServerRequestInterface::class))
        );
    }
}
