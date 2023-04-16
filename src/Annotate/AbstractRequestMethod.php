<?php
declare(strict_types=1);

namespace Kiri\Router\Annotate;

use Kiri\Router\Base\Middleware as MiddlewareManager;
use Kiri\Router\Interface\ValidatorInterface;
use Kiri\Router\Validator\Validator;
use Kiri\Router\Validator\ValidatorMiddleware;
use ReflectionException;

abstract class AbstractRequestMethod
{


	/**
	 * @param string $path
	 */
	public function __construct(readonly public string $path)
	{
	}


	/**
	 * @param object $class
	 * @param string $method
	 * @return void
	 * @throws ReflectionException
	 * @throws \Exception
	 */
	public function registerMiddleware(object $class, string $method): void
	{
		$reflectionMethod = \Kiri::getDi()->getMethod($class::class, $method);
		$middleware = $reflectionMethod->getAttributes(Middleware::class);

		$middlewareManager = \Kiri::getDi()->get(MiddlewareManager::class);
		foreach ($middleware as $value) {
			/** @var Middleware $instance */
			$instance = $value->newInstance();

			$middlewareManager->set($class::class, $method, $instance->middleware);
		}
	}

}
