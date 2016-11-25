<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Middleware;

use Interop\Http\Middleware\DelegateInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class DelegateMiddleware implements DelegateInterface
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * Create a new delegate callable middleware instance.
     *
     * @param callable $callback function (RequestInterface $request) : ResponseInterface
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(RequestInterface $request): ResponseInterface
    {
        return call_user_func($this->callback, $request);
    }
}
