<?php

namespace Kiri\Router\Annotate;

use Kiri\Router\Constrict\RequestMethod;
use Kiri\Router\Interface\InjectRouteInterface;
use Kiri\Router\Router;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Route extends AbstractRequestMethod implements InjectRouteInterface
{


	/**
	 * @param string $path
	 * @param RequestMethod $method
	 */
	public function __construct(readonly public string $path, readonly public RequestMethod $method)
	{
	}


	/**
	 * @param object $class
	 * @param string $method
	 * @return void
	 * @throws \ReflectionException
	 */
	public function dispatch(object $class, string $method): void
	{
		// TODO: Implement dispatch() method.
		Router::addRoute($this->method, $this->path, [$class, $method]);

		$this->registerMiddleware($class, $method);
	}
}
