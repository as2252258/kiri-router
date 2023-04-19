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
			throw new Exception('Request Handler returns must implements on Psr\Http\Message\ResponseInterface');
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
		if (is_string($reflectionMethod)) {
			$reflectionMethod = $reflectionClass->getMethod($reflectionMethod);
		}

		if ($reflectionMethod->getReturnType()->getName() !== 'Psr\Http\Message\ResponseInterface') {
			throw new Exception('Request Handler returns must implements on Psr\Http\Message\ResponseInterface');
		}

		$container = \Kiri::getDi();
		$parameters = $container->getMethodParams($reflectionMethod);

		$method = $reflectionMethod->getName();

		/** @var ResponseInterface $response */
		$response = \Kiri::service()->get('response');
		$call = static function (RequestInterface $request) use ($response, $class, $method, $parameters) {
			if (!$class->beforeAction($request)) {
				return $response->withStatus(500);
			}
			$response = call_user_func([$class, $method], $parameters);
			$class->afterAction($response);
			return $response;
		};
		return new Handler($call, [\Kiri::service()->get('request')]);
	}

}
