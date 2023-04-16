<?php

declare(strict_types=1);

namespace Kiri\Router;


use Closure;
use Exception;
use Kiri;
use Kiri\Router\Base\NotFoundController;
use Kiri\Router\Constrict\RequestMethod;
use ReflectionException;
use Throwable;
use Traversable;
use Kiri\Router\Base\Middleware;
use Kiri\Core\HashMap;


/**
 *
 */
class RouterCollector implements \ArrayAccess, \IteratorAggregate
{


	private array $_item = [];


	public array $groupTack = [];


	/**
	 * @var HashMap
	 */
	private HashMap $methods;


	public function __construct()
	{
		$this->methods = new HashMap();
	}


	/**
	 * @return Traversable
	 */
	public function getIterator(): Traversable
	{
		return new \ArrayIterator($this->_item);
	}


	/**
	 * @param array $method
	 * @param string $route
	 * @param string|array|Closure $closure
	 */
	public function addRoute(array $method, string $route, string|array|Closure $closure)
	{
		try {
			$route = $this->_splicing_routing($route);
			$interpreter = Kiri::getDi()->get(ControllerInterpreter::class);
			if ($closure instanceof Closure) {
				$handler = $interpreter->addRouteByClosure($closure);
			} else {
				$handler = $this->resolve($closure, $interpreter);
			}
			foreach ($method as $value) {
				if ($value instanceof RequestMethod) {
					$value = $value->getString();
				}
				$this->register($route, $value, $handler);
			}
		} catch (Throwable $throwable) {
			error($throwable->getMessage(), [throwable($throwable)]);
		}
	}


	/**
	 * @param string|array $closure
	 * @param ControllerInterpreter $interpreter
	 * @return Handler
	 * @throws ReflectionException
	 */
	private function resolve(string|array $closure, ControllerInterpreter $interpreter): Handler
	{
		if (is_array($closure)) {
			[$class, $method] = $closure;
		} else {
			[$className, $method] = explode('@', $closure);

			$class = Kiri::getDi()->get($this->resetName($className));
		}
		return $interpreter->addRouteByString($class, $method);
	}


	/**
	 * @param string $className
	 * @return string
	 */
	private function resetName(string $className): string
	{
		$namespace = array_filter(array_column($this->groupTack, 'namespace'));
		if (count($namespace) < 1) {
			return $className;
		}
		return implode('\\', $namespace) . '\\' . $className;
	}


	/**
	 * @param string $path
	 * @param string $method
	 * @param Handler $handler
	 * @return void
	 * @throws ReflectionException
	 */
	public function register(string $path, string $method, Handler $handler): void
	{
		$hashMap = HashMap::Tree($this->methods, $method);
		foreach (str_split($path, 4) as $item) {
			if ($hashMap->has($item)) {
				$hashMap = $hashMap->get($item);
			} else {
				$hashMap->put($item, $hashMap = new HashMap());
			}
		}
		$hashMap->put('handler', $handler);

		$this->registerMiddleware($handler->getClass(), $handler->getMethod());
	}


	/**
	 * @param string $class
	 * @param string $method
	 * @return void
	 * @throws ReflectionException
	 * @throws Exception
	 */
	public function registerMiddleware(string $class, string $method): void
	{
		$middlewares = array_column($this->groupTack, 'middleware');
		if (count($middlewares) > 0) {
			$manager = Kiri::getDi()->get(Middleware::class);
			foreach ($middlewares as $middleware) {
				if (is_string($middleware)) {
					$middleware = [$middleware];
				}
				foreach ($middleware as $value) {
					$manager->set($class, $method, $value);
				}
			}
		}
	}


	/**
	 * @param string $path
	 * @param string $method
	 * @return Handler|null
	 * @throws ReflectionException
	 */
	public function query(string $path, string $method): ?Handler
	{
		if (!$this->methods->has($method)) {
			return $this->NotFundHandler($path);
		}
		$parent = $this->methods->get($method);
		foreach (str_split($path, 4) as $item) {
			$parent = $parent->get($item);
			if ($parent === null) {
				return $this->NotFundHandler($path);
			}
		}
		return $parent->get('handler');
	}


	/**
	 * @param string $path
	 * @return Handler
	 * @throws ReflectionException
	 */
	private function NotFundHandler(string $path): Handler
	{
		return new Handler([di(NotFoundController::class), 'fail'], []);
	}

	/**
	 * @param string $route
	 * @return string
	 */
	protected function _splicing_routing(string $route): string
	{
		$route = ltrim($route, '/');
		$prefix = array_column($this->groupTack, 'prefix');
		if (empty($prefix = array_filter($prefix))) {
			return '/' . $route;
		}
		return '/' . implode('/', $prefix) . '/' . $route;
	}


	/**
	 * @param mixed $offset
	 * @return bool
	 */
	public function offsetExists(mixed $offset): bool
	{
		// TODO: Implement offsetExists() method.
		return isset($this->_item[$offset]);
	}


	/**
	 * @param mixed $offset
	 * @return Router|null
	 */
	public function offsetGet(mixed $offset): ?Router
	{
		if ($this->offsetExists($offset)) {
			return $this->_item[$offset];
		}
		return null;
	}


	/**
	 * @param mixed $offset
	 * @param mixed $value
	 * @return void
	 */
	public function offsetSet(mixed $offset, mixed $value): void
	{
		// TODO: Implement offsetSet() method.
		$this->_item[$offset] = $value;
	}


	/**
	 * @param mixed $offset
	 * @return void
	 */
	public function offsetUnset(mixed $offset): void
	{
		unset($this->_item[$offset]);
	}
}
