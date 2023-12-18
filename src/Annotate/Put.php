<?php
declare(strict_types=1);

namespace Kiri\Router\Annotate;

use Kiri;
use Kiri\Router\Constrict\RequestMethod;
use Kiri\Router\Interface\InjectRouteInterface;
use Kiri\Router\Router;
use ReflectionClass;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Put extends AbstractRequestMethod implements InjectRouteInterface
{


    /**
     * @param string $path
     * @param string $version
     */
    public function __construct(readonly public string $path, readonly public string $version = '')
    {
    }


    /**
     * @param object $class
     * @param string $method
     * @return void
     * @throws
     */
    public function dispatch(ReflectionClass $class, string $method): void
    {
        $controller = Kiri::getDi()->makeReflection($class);
        // TODO: Implement dispatch() method.
        $path = '/' . ltrim($this->path, '/');
        if (!empty($this->version)) {
            $path = '/' . trim($this->version) . $path;
        }
        Router::addRoute(RequestMethod::REQUEST_PUT, $path, [$controller, $method]);
    }

}
