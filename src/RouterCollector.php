<?php

declare(strict_types=1);

namespace Kiri\Router;


use Closure;
use Exception;
use Kiri;
use Kiri\Router\Base\NotFoundController;
use Kiri\Router\Constrict\RequestMethod;
use ReflectionException;
use Throwable;
use Traversable;
use Kiri\Router\Base\Middleware;


/**
 *
 */
class RouterCollector implements \ArrayAccess, \IteratorAggregate
{


    /**
     * @var array
     */
    private array $_item = [];


    /**
     * @var array
     */
    private array $dump = [];


    /**
     * @var array
     */
    public array $groupTack = [];


    /**
     * @var array<string, Handler>
     */
    private array $methods = [];


    /**
     * @var array<string, HttpRequestHandler>
     */
    protected array $httpHandler = [];


    /**
     * @var Handler
     */
    protected Handler $found;


    /**
     * @throws ReflectionException
     */
    public function __construct()
    {
        $found = di(NotFoundController::class);

        $reflection = new \ReflectionMethod($found, 'fail');

        $this->found = new Handler([$found, 'fail'], [], $reflection->getReturnType());
    }


    /**
     * @return Handler[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }


    /**
     * @param string $method
     * @param HttpRequestHandler $handler
     * @return void
     */
    public function setHttpHandler(string $method, HttpRequestHandler $handler): void
    {
        $this->httpHandler[$method] = $handler;
    }


    /**
     * @return array
     */
    public function getDump(): array
    {
        return $this->dump;
    }


    /**
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->_item);
    }


    /**
     * @param array $method
     * @param string $route
     * @param string|array|Closure $closure
     */
    public function addRoute(array $method, string $route, string|array|Closure $closure): void
    {
        try {
            $route       = $this->_splicing_routing($route);
            $interpreter = Kiri::getDi()->get(ControllerInterpreter::class);
            if ($closure instanceof Closure) {
                $handler = $interpreter->addRouteByClosure($closure);
            } else {
                $handler = $this->resolve($closure, $interpreter);
            }
            foreach ($method as $value) {
                if ($value instanceof RequestMethod) {
                    $value = $value->getString();
                }
                if (is_array($closure)) {
                    $closure[0] = is_object($closure[0]) ? get_class($closure[0]) : $closure;
                } else if (is_string($closure)) {
                    $closure = explode('@', $closure);
                }
                $this->dump[] = [
                    'method'   => $value,
                    'path'     => $route,
                    'callback' => $closure instanceof Closure ? 'Closure' : $closure
                ];
                $this->register($route, $value, $handler);
            }
        } catch (Throwable $throwable) {
            error($throwable);
        }
    }


    /**
     * @param string|array $closure
     * @param ControllerInterpreter $interpreter
     * @return Handler
     * @throws ReflectionException
     */
    private function resolve(string|array $closure, ControllerInterpreter $interpreter): Handler
    {
        if (is_array($closure)) {
            [$class, $method] = $closure;
        } else {
            if (!str_contains($closure, '@')) {
                $closure .= '@';
            }
            [$className, $method] = explode('@', $closure);

            $class = Kiri::getDi()->get($this->resetName($className));
        }
        return $interpreter->addRouteByString($class, $method);
    }


    /**
     * @param string $className
     * @return string
     */
    private function resetName(string $className): string
    {
        $namespace = array_filter(array_column($this->groupTack, 'namespace'));
        if (count($namespace) < 1) {
            return $className;
        }
        return implode('\\', $namespace) . '\\' . $className;
    }


    /**
     * @param string $path
     * @param string $method
     * @param Handler $handler
     * @return void
     * @throws Exception
     */
    public function register(string $path, string $method, Handler $handler): void
    {
        $this->methods[$method . '_' . $path] = $handler;
        $this->registerMiddleware($handler->getClass(), $handler->getMethod());
    }


    /**
     * @param string $class
     * @param string $method
     * @return void
     * @throws Exception
     */
    public function registerMiddleware(string $class, string $method): void
    {
        $middlewares = \request()->middlewares;
        if (count($middlewares) > 0) {
            $this->appendMiddleware($middlewares, $class, $method);
        }
        $middlewares = array_column($this->groupTack, 'middleware');
        if (count($middlewares) > 0) {
            $this->appendMiddleware($middlewares, $class, $method);
        }
    }


    /**
     * @param array $middlewares
     * @param $class
     * @param $method
     * @return void
     * @throws
     */
    private function appendMiddleware(array $middlewares, $class, $method): void
    {
        $manager = Kiri::getDi()->get(Middleware::class);
        foreach ($middlewares as $middleware) {
            if (is_string($middleware)) {
                $middleware = [$middleware];
            }
            foreach ($middleware as $value) {
                $manager->set($class, $method, $value);
            }
        }
    }

    /**
     * @param string $path
     * @param string $method
     * @return HttpRequestHandler
     * @throws ReflectionException
     */
    public function query(string $path, string $method): HttpRequestHandler
    {
        return $this->httpHandler[$method . '_' . $path] ?? new HttpRequestHandler([], $this->found);
    }


    /**
     * @param string $route
     * @return string
     */
    protected function _splicing_routing(string $route): string
    {
        $route  = ltrim($route, '/');
        $prefix = array_column($this->groupTack, 'prefix');
        if (empty($prefix = array_filter($prefix))) {
            return '/' . $route;
        }
        return '/' . implode('/', $prefix) . '/' . $route;
    }


    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        // TODO: Implement offsetExists() method.
        return isset($this->_item[$offset]);
    }


    /**
     * @param mixed $offset
     * @return Router|null
     */
    public function offsetGet(mixed $offset): ?Router
    {
        if ($this->offsetExists($offset)) {
            return $this->_item[$offset];
        }
        return null;
    }


    /**
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        // TODO: Implement offsetSet() method.
        $this->_item[$offset] = $value;
    }


    /**
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->_item[$offset]);
    }
}
