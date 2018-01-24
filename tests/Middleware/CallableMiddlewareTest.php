<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Middleware;

use Narrowspark\TestingHelper\Middleware\CallableMiddleware;
use PHPUnit\Framework\TestCase;

class CallableMiddlewareTest extends TestCase
{
    /**
     * @expectedException \RuntimeException
     */
    public function testConstructorThrowErrorOnWrongResponseFactory(): void
    {
        new CallableMiddleware(
            function (): void {
            },
            CallableMiddlewareTest::class
        );
    }
}
