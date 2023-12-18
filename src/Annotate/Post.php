<?php
declare(strict_types=1);

namespace Kiri\Router\Annotate;

use Kiri;
use Kiri\Router\Constrict\RequestMethod;
use Kiri\Router\Interface\InjectRouteInterface;
use Kiri\Router\Router;
use ReflectionClass;
use ReflectionException;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Post extends AbstractRequestMethod implements InjectRouteInterface
{


    /**
     * @param string $path
     * @param string $version
     */
	public function __construct(readonly public string $path, readonly public string $version = '')
	{
	}


    /**
     * @param ReflectionClass $class
     * @param string $method
     * @return void
     * @throws ReflectionException
     */
	public function dispatch(ReflectionClass $class, string $method): void
	{
		// TODO: Implement dispatch() method.
        $controller = Kiri::getDi()->makeReflection($class);

		$path = '/' . ltrim($this->path, '/');
        if (!empty($this->version)) {
            $path = '/' . trim($this->version) . $path;
        }
		Router::addRoute(RequestMethod::REQUEST_POST, $path, [$controller, $method]);
	}


}
