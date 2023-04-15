<?php

namespace Kiri\Inject\Route;

use Kiri\Inject\InjectPropertyInterface;
use Kiri\Message\Handler\Abstracts\MiddlewareManager;

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
		// TODO: Implement dispatch() method.
		MiddlewareManager::add($class::class, $property, $this->middleware);
	}


}
