<?php
declare(strict_types=1);

namespace Kiri\Router;

use Closure;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class ControllerInterpreter
{


	/**
	 * @param object $class
	 * @param string|ReflectionMethod $method
	 * @param ReflectionClass|null $reflection
	 * @return Handler
	 * @throws ReflectionException
	 */
	public function addRouteByString(object $class, string|ReflectionMethod $method, ?ReflectionClass $reflection = null): Handler
	{
		if (is_null($reflection)) {
			$reflection = \Kiri::getDi()->getReflectionClass($class::class);
		}
		return $this->resolveMethod($method, $reflection);
	}


	/**
	 * @param Closure $method
	 * @return Handler
	 * @throws ReflectionException
	 */
	public function addRouteByClosure(Closure $method): Handler
	{
		$reflection = \Kiri::getDi()->getFunctionParams($method);

		return new Handler($method, $reflection);
	}


	/**
	 * @param object $class
	 * @param string|ReflectionMethod $method
	 * @param ReflectionClass|null $reflection
	 * @return Handler
	 * @throws ReflectionException
	 */
	public function addRouteByObject(object $class, string|ReflectionMethod $method, ?ReflectionClass $reflection = null): Handler
	{
		if (is_null($reflection)) {
			$reflection = \Kiri::getDi()->getReflectionClass($class::class);
		}
		return $this->resolveMethod($method, $reflection);
	}


	/**
	 * @param string|ReflectionMethod $reflectionMethod
	 * @param ReflectionClass $reflectionClass
	 * @return Handler
	 * @throws ReflectionException
	 */
	public function resolveMethod(string|\ReflectionMethod $reflectionMethod, ReflectionClass $reflectionClass): Handler
	{
		if (is_string($reflectionMethod)) {
			$reflectionMethod = $reflectionClass->getMethod($reflectionMethod);
		}

		$container = \Kiri::getDi();
		$parameters = $container->getMethodParams($reflectionMethod);

		return new Handler([$reflectionClass->getName(), $reflectionMethod->getName()], $parameters);
	}

}
