<?php
declare(strict_types=1);

namespace Kiri\Router\Annotate;

use Exception;
use Kiri\Router\AnnotateRouteInterface;
use Kiri\Router\Router;
use ReflectionException;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Other extends AbstractRequestMethod implements InjectRouteInterface
{


	/**
	 * @param string $method
	 * @param string $path
	 * @param string $formValidate
	 */
	public function __construct(readonly public string $method, string $path, string $formValidate = '')
	{
		parent::__construct($path, $formValidate);
	}


	/**
	 * @param object $class
	 * @param string $method
	 * @return void
	 * @throws ReflectionException
	 * @throws Exception
	 */
	public function dispatch(object $class, string $method): void
	{
		// TODO: Implement dispatch() method.
		Router::addRoute([$this->method], $this->path, [$class, $method]);

		$this->registerMiddleware($class, $method);
	}


}
