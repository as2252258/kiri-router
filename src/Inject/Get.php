<?php

namespace Kiri\Router\Inject;

use Exception;
use Kiri\Annotation\Route\RequestMethod;
use Kiri\Router\InjectRouteInterface;
use Kiri\Router\Router;
use ReflectionException;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Get extends AbstractRequestMethod implements InjectRouteInterface
{


	/**
	 * @param object $class
	 * @param string $method
	 * @return void
	 * @throws ReflectionException
	 * @throws Exception
	 * @throws ReflectionException
	 */
	public function dispatch(object $class, string $method): void
	{
		// TODO: Implement dispatch() method.
		Router::addRoute(RequestMethod::REQUEST_GET, $this->path, [$class, $method]);

		$this->registerMiddleware($class, $method);
	}

}
