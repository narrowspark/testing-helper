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

namespace Narrowspark\TestingHelper\Middleware;

use LogicException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class Dispatcher implements MiddlewareInterface
{
    /** @var array */
    private $stack;

    /** @var null|\Psr\Http\Server\RequestHandlerInterface */
    private $delegate;

    /**
     * @param \Psr\Http\Server\MiddlewareInterface[] $stack middleware stack (with at least one middleware component)
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
     * @return \Psr\Http\Server\RequestHandlerInterface
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

        return new RequestHandlerMiddleware(static function (): void {
            throw new LogicException('Unresolved request: middleware stack exhausted with no result.');
        });
    }
}
