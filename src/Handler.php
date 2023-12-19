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
use ReflectionFunction;
use ReflectionMethod;
use ReflectionNamedType;

class Handler implements RequestHandlerInterface
{

    /**
     * @var IFormat
     */
    protected mixed $format;


    protected array $methods = [];


    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    protected array $parameters;


    /**
     * @param array|Closure $handler
     * @param ReflectionMethod|ReflectionFunction $parameter
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(public array|Closure $handler, public ReflectionMethod|ReflectionFunction $parameter)
    {
        $this->container = \Kiri::getDi();
        if ($this->parameter->getReturnType() != null) {
            $this->format = $this->container->get($this->returnType($parameter));
        } else {
            $this->format = $this->container->get(MixedFormat::class);
        }
        $this->parameters = $this->container->getMethodParams($this->parameter);
    }


    /**
     * @param $reflectionType
     * @return string
     */
    protected function returnType($reflectionType): string
    {
        return match ($reflectionType->getName()) {
            'array'                 => ArrayFormat::class,
            'mixed', 'object'       => MixedFormat::class,
            'int', 'string', 'bool' => OtherFormat::class,
            'void'                  => VoidFormat::class,
            default                 => ResponseFormat::class
        };
    }


    /**
     * @param string $method
     * @return void
     * @throws
     */
    public function setRequestMethod(string $method): void
    {
        if ($method == 'HEAD') {
            $this->format = $this->container->get(NoBody::class);
        }
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
     * @throws
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = call_user_func($this->handler, ...$this->parameters);

        /** 根据返回类型 */
        return $this->format->call($data);
    }

}
