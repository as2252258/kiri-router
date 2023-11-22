<?php
declare(strict_types=1);

namespace Kiri\Router;

use Closure;
use Kiri\Router\Format\ArrayFormat;
use Kiri\Router\Format\IFormat;
use Kiri\Router\Format\MixedFormat;
use Kiri\Router\Format\NoBody;
use Kiri\Router\Format\OtherFormat;
use Kiri\Router\Format\ResponseFormat;
use Kiri\Router\Format\VoidFormat;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
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
     * @var ContainerInterface
     */
    protected ContainerInterface $container;


    /**
     * @param array|Closure $handler
     * @param array $parameter
     * @param ReflectionNamedType|null $reflectionType
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function __construct(public array|Closure $handler, public array $parameter, public ?ReflectionNamedType $reflectionType)
    {
        $this->container = \Kiri::getDi();
        if ($this->reflectionType != null) {
            $this->format = $this->container->get($this->returnType());
        } else {
            $this->format = $this->container->get(MixedFormat::class);
        }
    }


    /**
     * @return string
     */
    protected function returnType(): string
    {
        return match ($this->reflectionType->getName()) {
            'array'                 => ArrayFormat::class,
            'mixed', 'object'       => MixedFormat::class,
            'int', 'string', 'bool' => OtherFormat::class,
            'void'                  => VoidFormat::class,
            default                 => ResponseFormat::class
        };
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

        /** 根据返回类型 */
        return $this->format->call($data);
    }

}
