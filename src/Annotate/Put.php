<?php
declare(strict_types=1);

namespace Kiri\Router\Annotate;

use Exception;
use Kiri\Router\Constrict\RequestMethod;
use Kiri\Router\AnnotateRouteInterface;
use Kiri\Router\Router;
use Kiri\Router\Base\Middleware as MiddlewareManager;
use ReflectionException;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Put extends AbstractRequestMethod implements InjectRouteInterface
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
		Router::addRoute(RequestMethod::REQUEST_PUT, $this->path, [$class, $method]);

		$this->registerMiddleware($class, $method);
	}

}
