<?php

namespace Kiri\Router\Annotate;

use Kiri\Router\Constrict\RequestMethod;
use Kiri\Router\Interface\InjectRouteInterface;
use Kiri\Router\Router;
use ReflectionException;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Route extends AbstractRequestMethod implements InjectRouteInterface
{


    /**
     * @param string $path
     * @param RequestMethod $method
     * @param string $version
     */
    public function __construct(readonly public string $path, readonly public RequestMethod $method, readonly public string $version = '')
    {
    }


    /**
     * @param object $class
     * @param string $method
     * @return void
     */
    public function dispatch(object $class, string $method): void
    {
        // TODO: Implement dispatch() method.
        $path = '/' . ltrim($this->path, '/');
        if (!empty($this->version)) {
            $path = '/' . trim($this->version) . $path;
        }
        Router::addRoute([$this->method], $path, [$class, $method]);
    }
}
