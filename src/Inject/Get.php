<?php

namespace Kiri\Inject\Route;

use Kiri\Annotation\Route\RequestMethod;
use Kiri\Message\Handler\Router;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Get extends AbstractRequestMethod implements InjectRouteInterface
{


	/**
	 * @param string $path
	 * @param array $params
	 */
	public function __construct(public string $path, public array $params = [])
	{
	}


	/**
	 * @param object $class
	 * @param string $method
	 * @return void
	 */
	public function dispatch(object $class, string $method): void
	{
		// TODO: Implement dispatch() method.
		Router::addRoute(RequestMethod::REQUEST_GET, $this->path, [$class, $method]);
	}

}
