<?php
declare(strict_types=1);

namespace Kiri\Router\Annotate;


use Kiri\Router\Interface\InjectRouteInterface;
use ReflectionClass;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Interceptor implements InjectRouteInterface
{

    public function __construct()
    {
    }


    /**
     * @param ReflectionClass $class
     * @param string $method
     * @return void
     */
    public function dispatch(ReflectionClass $class, string $method): void
    {
        // TODO: Implement dispatch() method.
    }

}
