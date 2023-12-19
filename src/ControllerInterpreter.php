<?php
declare(strict_types=1);

namespace Kiri\Router;

use Closure;
use Exception;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionMethod;

class ControllerInterpreter
{


    /**
     * @param ContainerInterface $container
     */
    public function __construct(public ContainerInterface $container)
    {
    }


    /**
     * @param object $class
     * @param string|ReflectionMethod $method
     * @param ReflectionClass|null $reflection
     * @return Handler
     * @throws
     */
    public function addRouteByString(object $class, string|ReflectionMethod $method, ?ReflectionClass $reflection = null): Handler
    {
        if (is_null($reflection)) {
            $reflection = $this->container->getReflectionClass($class::class);
        }
        return $this->resolveMethod($class, $method, $reflection);
    }


    /**
     * @param Closure $method
     * @return Handler
     * @throws
     */
    public function addRouteByClosure(Closure $method): Handler
    {
        $reflection = new \ReflectionFunction($method);

        return new Handler($method, $reflection);
    }


    /**
     * @param object $class
     * @param string|ReflectionMethod $method
     * @param ReflectionClass|null $reflection
     * @return Handler
     * @throws
     */
    public function addRouteByObject(object $class, string|ReflectionMethod $method, ?ReflectionClass $reflection = null): Handler
    {
        if (is_null($reflection)) {
            $reflection = $this->container->getReflectionClass($class::class);
        }
        return $this->resolveMethod($class, $method, $reflection);
    }


    /**
     * @param object $class
     * @param string|ReflectionMethod $reflectionMethod
     * @param ReflectionClass $reflectionClass
     * @return Handler
     * @throws
     */
    public function resolveMethod(object $class, string|\ReflectionMethod $reflectionMethod, ReflectionClass $reflectionClass): Handler
    {
        if (is_string($reflectionMethod)) {
            $reflectionMethod = $reflectionClass->getMethod($reflectionMethod);
        }

        return new Handler([$class, $reflectionMethod->getName()], $reflectionMethod);
    }

}
