<?php
declare(strict_types=1);

namespace Kiri\Router\Inject;

use Exception;
use Kiri\Router\Constrict\RequestMethod;
use Kiri\Router\InjectRouteInterface;
use Kiri\Router\Router;
use ReflectionException;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Options extends AbstractRequestMethod implements InjectRouteInterface
{




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
		Router::addRoute(RequestMethod::REQUEST_OPTIONS, $this->path, [$class, $method]);

		$this->registerMiddleware($class, $method);
	}


}
