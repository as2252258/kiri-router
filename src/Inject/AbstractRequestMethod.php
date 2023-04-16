<?php
declare(strict_types=1);

namespace Kiri\Router\Inject;

use Kiri\Router\Base\Middleware as MiddlewareManager;
use Kiri\Router\Interface\ValidatorInterface;
use Kiri\Router\Validator\Validator;
use Kiri\Router\Validator\ValidatorMiddleware;
use ReflectionException;

abstract class AbstractRequestMethod
{


	/**
	 * @param string $path
	 * @param string $formValidate
	 */
	public function __construct(readonly public string $path, public string $formValidate = '')
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

		if ($this->formValidate !== '') {
			$middlewareManager->set($class::class, $method, ValidatorMiddleware::class, [$this->getFormRule()]);
		}
	}


	/**
	 * @return Validator|null
	 * @throws ReflectionException
	 */
	public function getFormRule(): ?Validator
	{
		$validator = new Validator();
		$reflect = \Kiri::getDi()->getReflectionClass($this->formValidate);
		$model = $reflect->newInstanceWithoutConstructor();
		foreach ($reflect->getProperties() as $property) {
			foreach ($property->getAttributes() as $attribute) {
				$rule = $attribute->newInstance();
				if ($rule instanceof ValidatorInterface) {
					$validator->addRule($property->getName(), $model, $rule);
				}
			}
		}
		return $validator;
	}
}
