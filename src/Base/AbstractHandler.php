<?php
declare(strict_types=1);

namespace Kiri\Router\Base;

use Kiri\Router\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use ReflectionException;

abstract class AbstractHandler
{


    public int $offset = 0;

    public array $middlewares = [];


    /**
     * @param array $middlewares
     * @param Handler $handler
     * @throws ReflectionException
     */
    public function __construct(array $middlewares, public Handler $handler)
    {
        foreach ($middlewares as $middleware) {
            $this->middlewares[] = di($middleware);
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws ReflectionException
     */
    public function execute(ServerRequestInterface $request): ResponseInterface
    {
        if (!isset($this->middlewares[$this->offset])) {
            return $this->handler->handle($request);
        }

        /** @var MiddlewareInterface $middleware */
        $middleware   = $this->middlewares[$this->offset];
        $this->offset += 1;

        return $middleware->process($request, $this);
    }

}
