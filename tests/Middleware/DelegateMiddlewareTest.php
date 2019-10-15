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
use Narrowspark\TestingHelper\Middleware\RequestHandlerMiddleware;
use Narrowspark\TestingHelper\Phpunit\MockeryTestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 *
 * @small
 */
final class DelegateMiddlewareTest extends MockeryTestCase
{
    public function testCallCallableWithProcess(): void
    {
        $middleware = new RequestHandlerMiddleware(function () {
            return $this->mock(ResponseInterface::class);
        });

        self::assertInstanceOf(
            ResponseInterface::class,
            $middleware->handle(new ServerRequest('GET', '/'))
        );
    }
}
