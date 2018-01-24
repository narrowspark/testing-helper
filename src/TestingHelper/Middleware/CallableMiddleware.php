<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Middleware;

use Interop\Http\Factory\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;
use Throwable;
use UnexpectedValueException;

class CallableMiddleware implements MiddlewareInterface
{
    /**
     * @var callable
     */
    private $handler;

    /**
     * A response factory class name.
     *
     * @var null|\Interop\Http\Factory\ResponseFactoryInterface
     */
    private $responseFactoryClassName;

    /**
     * Create a new CallableMiddleware instance.
     *
     * @param callable $handler
     * @param string   $responseFactoryClassName
     *
     * @throws \RuntimeException
     */
    public function __construct(callable $handler, string $responseFactoryClassName = null)
    {
        $this->handler  = $handler;

        if ($responseFactoryClassName !== null) {
            $interfaces = \class_implements($responseFactoryClassName);

            if (! \array_key_exists(ResponseFactoryInterface::class, $interfaces)) {
                throw new RuntimeException(\sprintf(
                    'Class name don\'t implements [%s] interface; [%s] given.',
                    ResponseFactoryInterface::class,
                    $responseFactoryClassName
                ));
            }

            $this->responseFactoryClassName = new $responseFactoryClassName();
        }
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
     * @param callable $callable
     * @param array    $arguments
     *
     * @throws \Throwable
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function execute($callable, array $arguments = []): ResponseInterface
    {
        ob_start();
        $level = ob_get_level();

        try {
            $return = \call_user_func_array($callable, $arguments);

            if ($return instanceof ResponseInterface) {
                $response = $return;
                $return   = '';
            } elseif (
                $return === null ||
                \is_scalar($return) ||
                (\is_object($return) && \method_exists($return, '__toString'))
            ) {
                $instance = $this->responseFactoryClassName;

                if ($instance === null) {
                    throw new RuntimeException('No ResponseFactory class found.');
                }

                $response = $instance->createResponse();
            } else {
                throw new UnexpectedValueException(
                    'The value returned must be scalar or an object with __toString method'
                );
            }

            while (\ob_get_level() >= $level) {
                $return = \ob_get_clean() . $return;
            }

            $body = $response->getBody();

            if ($return !== '' && $body->isWritable()) {
                $body->write($return);
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
