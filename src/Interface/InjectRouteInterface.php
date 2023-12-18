<?php
declare(strict_types=1);

namespace Kiri\Router\Interface;

use ReflectionClass;

interface InjectRouteInterface
{


    /**
     * @param ReflectionClass $class
     * @param string $method
     * @return void
     */
	public function dispatch(ReflectionClass $class, string $method): void;

}
