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
            new CallableMiddleware(function ($request, $delegate) {
                $response = $delegate->process($request);
                $response->getBody()->write('3');

                return $response;
            }),
            new CallableMiddleware(function ($request, $delegate) {
                $response = $delegate->process($request);
                $response->getBody()->write('2');

                return $response;
            }),
            new CallableMiddleware(function ($request, $delegate) {
                echo '1';
            }),
        ]);

        $response = $dispatcher->dispatch(new ServerRequest('GET', '/'));

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals('123', (string) $response->getBody());
    }

    public function testNestedDispatcher()
    {
        $dispatcher1 = new Dispatcher([
            new CallableMiddleware(function ($request, $delegate) {
                echo 3;

                return $delegate->process($request);
            }),
            new CallableMiddleware(function ($request, $delegate) {
                echo 2;

                return $delegate->process($request);
            }),
            new CallableMiddleware(function ($request, $delegate) {
                echo 1;
            }),
        ]);
        $dispatcher2 = new Dispatcher([
            new CallableMiddleware(function ($request, $delegate) {
                echo 5;

                return $delegate->process($request);
            }),
            new CallableMiddleware(function ($request, $delegate) {
                echo 4;

                return $delegate->process($request);
            }),
            $dispatcher1,
        ]);
        $dispatcher3 = new Dispatcher([
            new CallableMiddleware(function ($request, $delegate) {
                echo 7;

                return $delegate->process($request);
            }),
            new CallableMiddleware(function ($request, $delegate) {
                echo 6;

                return $delegate->process($request);
            }),
            $dispatcher2,
        ]);

        $response = $dispatcher3->dispatch(new ServerRequest('GET', '/'));

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals('1234567', (string) $response->getBody());

        $response = $dispatcher2->dispatch(new ServerRequest('GET', '/'));

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals('12345', (string) $response->getBody());

        $response = $dispatcher1->dispatch(new ServerRequest('GET', '/'));

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals('123', (string) $response->getBody());
    }
}
