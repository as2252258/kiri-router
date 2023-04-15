<?php

namespace Kiri\Router;

interface InjectRouteInterface
{


	/**
	 * @param object $class
	 * @param string $method
	 * @return void
	 */
	public function dispatch(object $class, string $method): void;

}
