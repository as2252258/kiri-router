<?php

namespace Kiri\Inject\Route;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Controller
{


	readonly public ?RequestInterface $request;



	readonly public ResponseInterface $response;


	/**
	 *
	 */
	public function __construct()
	{
		$this->request = \Kiri::getDi()->get(RequestInterface::class);

	}


	/**
	 * @param object $class
	 * @return void
	 * @throws ReflectionException
	 */
	public function dispatch(object $class): void
	{
		// TODO: Implement dispatch() method.
		$reflectionClass = \Kiri::getDi()->getReflect($class::class);

		$scheduler = \Kiri::getDi()->get(ControllerInterpreter::class);

		foreach ($reflectionClass->getMethods() as $reflectionMethod) {
			$scheduler->addRouteByObject($class, $reflectionMethod, $reflectionClass);
		}
	}

}
