<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Middleware;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Narrowspark\TestingHelper\Middleware\CallableMiddleware;
use Narrowspark\TestingHelper\Middleware\Dispatcher;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * @internal
 */
final class DispatcherTest extends TestCase
{
    /**
     * @var \GuzzleHttp\Psr7\ServerRequest
     */
    private $serverRequest;

    /**
     * @var \Psr\Http\Message\ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->serverRequest   = new ServerRequest('GET', '/');
        $this->responseFactory = new class() implements ResponseFactoryInterface {
            /**
             * Create a new response.
             *
             * @param int    $code         HTTP status code; defaults to 200
             * @param string $reasonPhrase reason phrase to associate with status code
             *                             in generated response; if none is provided implementations MAY use
             *                             the defaults as suggested in the HTTP specification
             *
             * @return ResponseInterface
             */
            public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
            {
                return (new Response($code))->withStatus($code, $reasonPhrase);
            }
        };
    }

    public function testDispatcherWithEmptyStack(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Unresolved request: middleware stack exhausted with no result.');

        $dispatcher = new Dispatcher([]);
        $dispatcher->dispatch($this->serverRequest);
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
                $this->responseFactory
            ),
        ]);

        $response = $dispatcher->dispatch($this->serverRequest);

        static::assertInstanceOf(ResponseInterface::class, $response);
        static::assertEquals('123', (string) $response->getBody());
    }

    public function testNestedDispatcher(): void
    {
        $dispatcher1 = new Dispatcher([
            new CallableMiddleware(
                function ($request, RequestHandlerInterface $handler) {
                    echo 3;

                    return $handler->handle($request);
                },
                $this->responseFactory
            ),
            new CallableMiddleware(
                function ($request, RequestHandlerInterface $handler) {
                    echo 2;

                    return $handler->handle($request);
                },
                $this->responseFactory
            ),
            new CallableMiddleware(
                function (): void {
                    echo 1;
                },
                $this->responseFactory
            ),
        ]);

        $dispatcher2 = new Dispatcher([
            new CallableMiddleware(
                function ($request, RequestHandlerInterface $handler) {
                    echo 5;

                    return $handler->handle($request);
                },
                $this->responseFactory
            ),
            new CallableMiddleware(
                function ($request, RequestHandlerInterface $handler) {
                    echo 4;

                    return $handler->handle($request);
                },
                $this->responseFactory
            ),
            $dispatcher1,
        ]);

        $dispatcher3 = new Dispatcher([
            new CallableMiddleware(
                function ($request, RequestHandlerInterface $handler) {
                    echo 7;

                    return $handler->handle($request);
                },
                $this->responseFactory
            ),
            new CallableMiddleware(
                function ($request, RequestHandlerInterface $handler) {
                    echo 6;

                    return $handler->handle($request);
                },
                $this->responseFactory
            ),
            $dispatcher2,
        ]);

        $response = $dispatcher3->dispatch($this->serverRequest);

        static::assertInstanceOf(ResponseInterface::class, $response);
        static::assertEquals('1234567', (string) $response->getBody());

        $response = $dispatcher2->dispatch($this->serverRequest);

        static::assertInstanceOf(ResponseInterface::class, $response);
        static::assertEquals('12345', (string) $response->getBody());

        $response = $dispatcher1->dispatch($this->serverRequest);

        static::assertInstanceOf(ResponseInterface::class, $response);
        static::assertEquals('123', (string) $response->getBody());
    }
}
