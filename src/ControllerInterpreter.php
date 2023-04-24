<?php
declare(strict_types=1);

namespace Kiri\Router;

use Closure;
use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
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
		return $this->resolveMethod($class, $method, $reflection);
	}


	/**
	 * @param Closure $method
	 * @return Handler
	 * @throws ReflectionException
	 * @throws Exception
	 */
	public function addRouteByClosure(Closure $method): Handler
	{
		$reflection = new \ReflectionFunction($method);
		if ($reflection->getReturnType()->getName() !== 'Psr\Http\Message\ResponseInterface') {
			die('Request Handler returns must implements on Psr\Http\Message\ResponseInterface');
		}
		$params = \Kiri::getDi()->resolveMethodParams($reflection);
		return new Handler($method, $params);
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
		return $this->resolveMethod($class, $method, $reflection);
	}


	/**
	 * @param object $class
	 * @param string|ReflectionMethod $reflectionMethod
	 * @param ReflectionClass $reflectionClass
	 * @return Handler
	 * @throws ReflectionException
	 * @throws Exception
	 */
	public function resolveMethod(object $class, string|\ReflectionMethod $reflectionMethod, ReflectionClass $reflectionClass): Handler
	{
		if (empty($reflectionMethod)) {
			return new Handler([$class, $reflectionMethod], []);
		}
		if (is_string($reflectionMethod)) {
			$reflectionMethod = $reflectionClass->getMethod($reflectionMethod);
		}

		if ($reflectionMethod->getReturnType()->getName() !== 'Psr\Http\Message\ResponseInterface') {
			die('Request Handler returns must implements on Psr\Http\Message\ResponseInterface');
		}

		$container = \Kiri::getDi();
		$parameters = $container->getMethodParams($reflectionMethod);

		return new Handler([$class, $reflectionMethod->getName()], $parameters);
	}

}
