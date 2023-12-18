<?php
declare(strict_types=1);

namespace Kiri\Router\Annotate;

use Kiri\Router\Base\Middleware as MiddlewareManager;
use Kiri\Router\Interface\InjectRouteInterface;
use ReflectionClass;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Middleware implements InjectRouteInterface
{

	/**
	 * @param string $middleware
	 */
	public function __construct(readonly public string $middleware)
	{
	}


    /**
     * @param ReflectionClass $class
     * @param string $method
     * @return void
     */
	public function dispatch(ReflectionClass $class, string $method): void
    {
		$middlewareManager = \Kiri::getDi()->get(MiddlewareManager::class);

		$middlewareManager->set($class->getName(), $method, $this->middleware);
	}


}
