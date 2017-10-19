<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Middleware;

use GuzzleHttp\Psr7\Response;
use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Viserio\HttpFactory\ResponseFactory;

class CallableMiddleware implements MiddlewareInterface
{
    /**
     * @var callable
     */
    private $handler;

    /**
     * Constructor.
     *
     * @param callable $handler
     */
    public function __construct(callable $handler)
    {
        $this->handler = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler)
    {
        return $this->execute($this->handler, [$request, $handler]);
    }

    /**
     * Execute the callable.
     *
     * @param callable $callable
     * @param array    $arguments
     *
     * @throws Throwable
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function execute($callable, array $arguments = []): ResponseInterface
    {
        ob_start();
        $level = ob_get_level();

        try {
            $return = call_user_func_array($callable, $arguments);

            if ($return instanceof ResponseInterface) {
                $response = $return;
                $return   = '';
            } else {
                if (class_exists(ResponseFactory::class)) {
                    $response = (new ResponseFactory())->createResponse();
                } else {
                    $response = new Response();
                }
            }

            while (ob_get_level() >= $level) {
                $return = ob_get_clean() . $return;
            }

            $body = $response->getBody();

            if ($return !== '' && $body->isWritable()) {
                $body->write($return);
            }

            return $response;
        } catch (Throwable $exception) {
            while (ob_get_level() >= $level) {
                ob_end_clean();
            }

            throw $exception;
        }
    }
}
