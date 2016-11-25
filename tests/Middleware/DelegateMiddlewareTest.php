<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Middleware;

use Narrowspark\TestingHelper\Middleware\DelegateMiddleware;
use Narrowspark\TestingHelper\Traits\MockeryTrait;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class DelegateMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    use MockeryTrait;

    public function testCallCallableWithProcess()
    {
        $middleware = new DelegateMiddleware(function () {
            return $this->mock(ResponseInterface::class);
        });

        $this->assertInstanceOf(
            ResponseInterface::class,
            $middleware->process($this->mock(RequestInterface::class))
        );
    }
}