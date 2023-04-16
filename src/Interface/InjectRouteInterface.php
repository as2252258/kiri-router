<?php
declare(strict_types=1);

namespace Kiri\Router\Interface;

interface InjectRouteInterface
{


	/**
	 * @param object $class
	 * @param string $method
	 * @return void
	 */
	public function dispatch(object $class, string $method): void;

}
