<?php
declare(strict_types=1);

namespace Kiri\Router\Base;

use Exception;
use Kiri\Core\HashMap;
use Psr\Http\Server\MiddlewareInterface;

class Middleware
{


	public HashMap $map;

	public HashMap $routeMap;


	/**
	 *
	 */
	public function __construct()
	{
		$this->map = new HashMap();
	}


	/**
	 * @param string $className
	 * @param string $method
	 * @param string|object $middleware
	 * @return void
	 * @throws Exception
	 */
	public function set(string $className, string $method, string|object $middleware): void
	{
		$path = $className . '::' . $method;
		if ($this->map->has($path)) {
			$values = $this->map->get($path);
			if (in_array($middleware, $values)) {
				return;
			}
			if (!in_array(MiddlewareInterface::class, class_implements($middleware))) {
				return;
			}
		}
		$this->map->append($path, $middleware);
	}


	/**
	 * @param string $className
	 * @param string $method
	 * @return array
	 */
	public function get(string $className, string $method): array
	{
		return $this->map->get($className . '::' . $method) ?? [];
	}


}
