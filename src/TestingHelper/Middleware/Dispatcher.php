<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Middleware;

use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use LogicException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Dispatcher implements MiddlewareInterface
{
    /**
     * @var array
     */
    private $stack;

    /**
     * @var \Interop\Http\Server\RequestHandlerInterface|null
     */
    private $delegate;

    /**
     * @param array $stack middleware stack (with at least one middleware component)
     */
    public function __construct(array $stack)
    {
        $this->stack = $stack;
    }

    /**
     * Dispatches the middleware stack and returns the resulting `ResponseInterface`.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        $resolved = $this->resolve(0);

        return $resolved->handle($request);
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $delegate): ResponseInterface
    {
        $this->delegate = $delegate;

        $response = $this->dispatch($request);

        $this->delegate = null;

        return $response;
    }

    /**
     * @param int $index middleware stack index
     *
     * @throws \LogicException
     *
     * @return \Interop\Http\Server\RequestHandlerInterface
     */
    private function resolve(int $index): RequestHandlerInterface
    {
        if (isset($this->stack[$index])) {
            return new RequestHandlerMiddleware(function (ServerRequestInterface $request) use ($index) {
                $middleware = $this->stack[$index];

                return $middleware->process($request, $this->resolve($index + 1));
            });
        }

        if ($this->delegate !== null) {
            return $this->delegate;
        }

        return new RequestHandlerMiddleware(function () {
            throw new LogicException('unresolved request: middleware stack exhausted with no result');
        });
    }
}
