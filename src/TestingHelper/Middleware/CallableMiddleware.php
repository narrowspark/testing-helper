<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;
use Throwable;
use UnexpectedValueException;

final class CallableMiddleware implements MiddlewareInterface
{
    /** @var callable */
    private $handler;

    /**
     * A response factory class name.
     *
     * @var null|\Psr\Http\Message\ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * Create a new CallableMiddleware instance.
     *
     * @param callable                                   $handler
     * @param \Psr\Http\Message\ResponseFactoryInterface $responseFactory
     *
     * @throws \RuntimeException
     */
    public function __construct(callable $handler, ResponseFactoryInterface $responseFactory = null)
    {
        $this->handler         = $handler;
        $this->responseFactory = $responseFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->execute($this->handler, [$request, $handler]);
    }

    /**
     * Execute the callable.
     *
     * @param callable|\Closure $callable
     * @param mixed[]           $arguments
     *
     * @throws \Throwable
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function execute(callable $callable, array $arguments = []): ResponseInterface
    {
        \ob_start();
        $level = \ob_get_level();

        try {
            $return = \call_user_func_array($callable, $arguments);

            if ($return instanceof ResponseInterface) {
                $response = $return;
                $return   = '';
            } elseif (
                $return === null
                || \is_scalar($return)
                || (\is_object($return) && \method_exists($return, '__toString'))
            ) {
                $instance = $this->responseFactory;

                if ($instance === null) {
                    throw new RuntimeException('No ResponseFactory class found.');
                }

                $response = $instance->createResponse();
            } else {
                throw new UnexpectedValueException(
                    'The value returned must be "scalar" or an object with "__toString" method.'
                );
            }

            while (\ob_get_level() >= $level) {
                $return = \ob_get_clean() . $return;
            }

            $body = $response->getBody();

            if ($return !== '' && $body->isWritable()) {
                $body->write((string) $return);
            }

            return $response;
        } catch (Throwable $exception) {
            while (\ob_get_level() >= $level) {
                \ob_end_clean();
            }

            throw $exception;
        }
    }
}
