<?php

namespace Kiri\Router\Annotate;

use Kiri\Router\Constrict\RequestMethod;
use Kiri\Router\Router;
use Kiri\Di\Interface\InjectMethodInterface;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Route extends AbstractRequestMethod implements InjectMethodInterface
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
     * @param string $class
     * @param string $method
     * @return void
     */
    public function dispatch(string $class, string $method): void
    {
        $controller = \Kiri::getDi()->get($class);
        $path = '/' . ltrim($this->path, '/');
        if (!empty($this->version)) {
            $path = '/' . trim($this->version) . $path;
        }
        Router::addRoute([$this->method], $path, [$controller, $method]);
    }
}
