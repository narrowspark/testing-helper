<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Middleware;

use Interop\Http\Middleware\DelegateInterface;
use Interop\Http\Middleware\ServerMiddlewareInterface;
use LogicException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Dispatcher implements ServerMiddlewareInterface
{
    /**
     * @var array
     */
    private $stack;

    /**
     * @var DeletageInterface|null
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

        return $resolved->process($request);
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $this->delegate = $delegate;

        $response = $this->dispatch($request);

        $this->delegate = null;

        return $response;
    }

    /**
     * @param int $index middleware stack index
     *
     * @return \Interop\Http\Middleware\DelegateInterface
     */
    private function resolve(int $index): DelegateInterface
    {
        if (isset($this->stack[$index])) {
            return new DelegateMiddleware(function (ServerRequestInterface $request) use ($index) {
                $middleware = $this->stack[$index];

                $result = $middleware->process($request, $this->resolve($index + 1));

                return $result;
            });
        }

        if ($this->delegate !== null) {
            return $this->delegate;
        }

        return new DelegateMiddleware(function () {
            throw new LogicException('unresolved request: middleware stack exhausted with no result');
        });
    }
}
