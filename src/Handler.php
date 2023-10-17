<?php
declare(strict_types=1);

namespace Kiri\Router;

use Closure;
use Kiri\Router\Format\ArrayFormat;
use Kiri\Router\Format\IFormat;
use Kiri\Router\Format\MixedFormat;
use Kiri\Router\Format\OtherFormat;
use Kiri\Router\Format\ResponseFormat;
use Kiri\Router\Format\VoidFormat;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReflectionException;
use ReflectionNamedType;

class Handler implements RequestHandlerInterface
{

    /**
     * @var IFormat
     */
    protected mixed $format;


    /**
     * @var array
     */
    protected array $middlewares = [];


    /**
     * @param array|Closure $handler
     * @param array $parameter
     * @param ReflectionNamedType $reflectionType
     * @throws ReflectionException
     */
    public function __construct(public array|Closure $handler, public array $parameter, public ReflectionNamedType $reflectionType)
    {
        $type         = match ($this->reflectionType->getName()) {
            'array' => ArrayFormat::class,
            'mixed', 'object' => MixedFormat::class,
            'int', 'string', 'bool' => OtherFormat::class,
            'void' => VoidFormat::class,
            default => ResponseFormat::class
        };
        $this->format = di($type);
    }


    /**
     * @param array $middlewares
     */
    public function setMiddlewares(array $middlewares): void
    {
        $this->middlewares = $middlewares;
    }


    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
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
        $data = call_user_func($this->handler, ...$this->parameter);
        return $this->format->call($data);
    }

}
