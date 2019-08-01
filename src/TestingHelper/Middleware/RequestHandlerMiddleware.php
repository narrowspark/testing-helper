<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RequestHandlerMiddleware implements RequestHandlerInterface
{
    /** @var callable */
    private $callback;

    /**
     * Create a new delegate callable middleware instance.
     *
     * @param callable $callback function (ServerRequestInterface $request) : ResponseInterface
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return \call_user_func($this->callback, $request);
    }
}
