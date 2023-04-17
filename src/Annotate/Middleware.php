<?php
declare(strict_types=1);

namespace Kiri\Router\Annotate;

use Kiri\Di\Interface\InjectPropertyInterface;
use Kiri\Router\Base\Middleware as MiddlewareManager;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Middleware implements InjectPropertyInterface
{

	/**
	 * @param string $middleware
	 */
	public function __construct(readonly public string $middleware)
	{
	}


	/**
	 * @param object $class
	 * @param string $property
	 * @return void
	 * @throws
	 */
	public function dispatch(object $class, string $property): void
	{
		$middlewareManager = \Kiri::getDi()->get(MiddlewareManager::class);

		$middlewareManager->set($class::class, $property, $this->middleware);
	}


}
