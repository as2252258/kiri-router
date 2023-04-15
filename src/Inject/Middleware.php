<?php
declare(strict_types=1);

namespace Kiri\Router\Inject;

use Kiri\Di\Interface\InjectPropertyInterface;

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
	 */
	public function dispatch(object $class, string $property): void
	{
	}


}
