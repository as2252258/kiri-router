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
		$this->routeMap = new HashMap();
		$this->map = new HashMap();
	}


	/**
	 * @param string $className
	 * @param string $method
	 * @param string $middleware
	 * @param array $construct
	 * @return void
	 * @throws Exception
	 */
	public function set(string $className, string $method, string $middleware, array $construct = []): void
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
		$this->map->append($path, [$middleware, $construct]);
	}


	/**
	 * @param string $className
	 * @param string $method
	 * @return array
	 */
	public function get(string $className, string $method): array
	{
		return $this->routeMap->get($className . '::' . $method) ?? [];
	}


	/**
	 * @param string $path
	 * @param mixed $middleware
	 * @return void
	 * @throws Exception
	 */
	public function addPathMiddleware(string $path, string $middleware): void
	{
		if ($this->routeMap->has($path)) {
			$values = $this->routeMap->get($path);
			if (in_array($middleware, $values)) {
				return;
			}
			if (!in_array(MiddlewareInterface::class, class_implements($middleware))) {
				return;
			}
		}
		$this->routeMap->append($path, $middleware);
	}

}
