<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Middleware;

use GuzzleHttp\Psr7\ServerRequest;
use Narrowspark\TestingHelper\Middleware\CallableMiddleware;
use Narrowspark\TestingHelper\Middleware\Dispatcher;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class DispatcherTest extends TestCase
{
    public function testDispatcher()
    {
        $dispatcher = new Dispatcher([
            new CallableMiddleware(function ($request, $handler) {
                $response = $handler->handle($request);
                $response->getBody()->write('3');

                return $response;
            }),
            new CallableMiddleware(function ($request, $handler) {
                $response = $handler->handle($request);
                $response->getBody()->write('2');

                return $response;
            }),
            new CallableMiddleware(function ($request, $handler) {
                echo '1';
            }),
        ]);

        $response = $dispatcher->dispatch(new ServerRequest('GET', '/'));

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals('123', (string) $response->getBody());
    }

    public function testNestedDispatcher()
    {
        $dispatcher1 = new Dispatcher([
            new CallableMiddleware(function ($request, $handler) {
                echo 3;

                return $handler->handle($request);
            }),
            new CallableMiddleware(function ($request, $handler) {
                echo 2;

                return $handler->handle($request);
            }),
            new CallableMiddleware(function ($request, $handler) {
                echo 1;
            }),
        ]);
        $dispatcher2 = new Dispatcher([
            new CallableMiddleware(function ($request, $handler) {
                echo 5;

                return $handler->handle($request);
            }),
            new CallableMiddleware(function ($request, $handler) {
                echo 4;

                return $handler->handle($request);
            }),
            $dispatcher1,
        ]);
        $dispatcher3 = new Dispatcher([
            new CallableMiddleware(function ($request, $handler) {
                echo 7;

                return $handler->handle($request);
            }),
            new CallableMiddleware(function ($request, $handler) {
                echo 6;

                return $handler->handle($request);
            }),
            $dispatcher2,
        ]);

        $response = $dispatcher3->dispatch(new ServerRequest('GET', '/'));

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals('1234567', (string) $response->getBody());

        $response = $dispatcher2->dispatch(new ServerRequest('GET', '/'));

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals('12345', (string) $response->getBody());

        $response = $dispatcher1->dispatch(new ServerRequest('GET', '/'));

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals('123', (string) $response->getBody());
    }
}
