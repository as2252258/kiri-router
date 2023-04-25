<?php
declare(strict_types=1);

namespace Kiri\Router\Annotate;

use Exception;
use Kiri\Router\Constrict\RequestMethod;
use Kiri\Router\Interface\InjectRouteInterface;
use Kiri\Router\Router;
use ReflectionException;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Get extends AbstractRequestMethod implements InjectRouteInterface
{


	/**
	 * @param string $path
	 * @param string $version
	 */
	public function __construct(readonly public string $path, readonly public string $version = 'v1')
	{
	}


	/**
	 * @param object $class
	 * @param string $method
	 * @return void
	 * @throws ReflectionException
	 * @throws Exception
	 */
	public function dispatch(object $class, string $method): void
	{
		// TODO: Implement dispatch() method.
		$path = '/' . ltrim($this->path, '/');

		Router::addRoute(RequestMethod::REQUEST_GET, $path, [$class, $method]);
	}

}
