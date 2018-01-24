<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Middleware;

use Http\Factory\Guzzle\ResponseFactory;
use Http\Factory\Guzzle\ServerRequestFactory;
use Narrowspark\TestingHelper\Middleware\CallableMiddleware;
use Narrowspark\TestingHelper\Middleware\Dispatcher;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DispatcherTest extends TestCase
{
    /**
     * @var \GuzzleHttp\Psr7\ServerRequest
     */
    private $serverRequest;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->serverRequest = (new ServerRequestFactory())->createServerRequest('GET', '/');
    }

    public function testDispatcher(): void
    {
        $dispatcher = new Dispatcher([
            new CallableMiddleware(function ($request, RequestHandlerInterface $handler) {
                $response = $handler->handle($request);
                $response->getBody()->write('3');

                return $response;
            }),
            new CallableMiddleware(function ($request, RequestHandlerInterface $handler) {
                $response = $handler->handle($request);
                $response->getBody()->write('2');

                return $response;
            }),
            new CallableMiddleware(
                function (): void {
                    echo '1';
                },
                ResponseFactory::class
            ),
        ]);

        $response = $dispatcher->dispatch($this->serverRequest);

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals('123', (string) $response->getBody());
    }

    public function testNestedDispatcher(): void
    {
        $dispatcher1 = new Dispatcher([
            new CallableMiddleware(
                function ($request, RequestHandlerInterface $handler) {
                    echo 3;

                    return $handler->handle($request);
                },
                ResponseFactory::class
            ),
            new CallableMiddleware(
                function ($request, RequestHandlerInterface $handler) {
                    echo 2;

                    return $handler->handle($request);
                },
                ResponseFactory::class
            ),
            new CallableMiddleware(
                function (): void {
                    echo 1;
                },
                ResponseFactory::class
            ),
        ]);

        $dispatcher2 = new Dispatcher([
            new CallableMiddleware(
                function ($request, RequestHandlerInterface $handler) {
                    echo 5;

                    return $handler->handle($request);
                },
                ResponseFactory::class
            ),
            new CallableMiddleware(
                function ($request, RequestHandlerInterface $handler) {
                    echo 4;

                    return $handler->handle($request);
                },
                ResponseFactory::class
            ),
            $dispatcher1,
        ]);

        $dispatcher3 = new Dispatcher([
            new CallableMiddleware(
                function ($request, RequestHandlerInterface $handler) {
                    echo 7;

                    return $handler->handle($request);
                },
                ResponseFactory::class
            ),
            new CallableMiddleware(
                function ($request, RequestHandlerInterface $handler) {
                    echo 6;

                    return $handler->handle($request);
                },
                ResponseFactory::class
            ),
            $dispatcher2,
        ]);

        $response = $dispatcher3->dispatch($this->serverRequest);

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals('1234567', (string) $response->getBody());

        $response = $dispatcher2->dispatch($this->serverRequest);

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals('12345', (string) $response->getBody());

        $response = $dispatcher1->dispatch($this->serverRequest);

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals('123', (string) $response->getBody());
    }
}
