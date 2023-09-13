<?php
declare(strict_types=1);

namespace Kiri\Router;

use Closure;
use Kiri\Router\Constrict\Stream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReflectionException;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionUnionType;

class Handler implements RequestHandlerInterface
{

    /**
     * @param array|Closure $handler
     * @param array $parameter
     * @param ReflectionNamedType|ReflectionUnionType|ReflectionIntersectionType|null $responseType
     */
    public function __construct(public array|Closure $handler, public array $parameter, public ReflectionNamedType|ReflectionUnionType|ReflectionIntersectionType|null $responseType)
    {
    }


    /**
     * @return bool
     */
    public function isClosure(): bool
    {
        return $this->handler instanceof Closure;
    }


    /**
     * @param string $interface
     * @return bool
     */
    public function implement(string $interface): bool
    {
        if (!$this->isClosure()) {
            return $this->handler[0] instanceof $interface;
        }
        return false;
    }


    /**
     * @return string|null
     */
    public function getClass(): ?string
    {
        if ($this->isClosure()) {
            return null;
        }
        return $this->handler[0]::class;
    }


    /**
     * @return string|null
     */
    public function getMethod(): ?string
    {
        if ($this->isClosure()) {
            return null;
        }
        return $this->handler[1];
    }


    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws ReflectionException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // TODO: Implement handle() method.
        if ($this->responseType->getName() !== 'void') {
            return $this->typeEncode();
        }
        call_user_func($this->handler, ...$this->parameter);
        return response();
    }


    /**
     * @return ResponseInterface
     */
    protected function typeEncode(): ResponseInterface
    {
        $result = call_user_func($this->handler, ...$this->parameter);
        if ($result instanceof ResponseInterface) {
            return $result;
        }
        if (is_object($result)) {
            $result = '[object]';
        } else if (is_array($result)) {
            $result = json_encode($result, JSON_UNESCAPED_UNICODE);
        }
        return response()->withBody(new Stream($result));
    }

}
