<?php
declare(strict_types=1);

namespace Kiri\Router\Annotate;

use Kiri\Di\Interface\InjectMethodInterface;
use Kiri\Router\Base\Middleware as MiddlewareManager;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Middleware implements InjectMethodInterface
{

	/**
	 * @param string $middleware
	 */
	public function __construct(readonly public string $middleware)
	{
	}


    /**
     * @param string $class
     * @param string $method
     * @return void
     */
	public function dispatch(string $class, string $method): void
    {
        MiddlewareManager::set($class, $method, $this->middleware);
	}


}
