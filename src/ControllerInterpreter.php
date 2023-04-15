<?php

namespace Kiri\Router\Inject;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class ControllerInterpreter
{


	/**
	 * @param string $className
	 * @param string|ReflectionMethod $method
	 * @param ReflectionClass|null $reflection
	 * @return void
	 * @throws ReflectionException
	 */
	public function addRouteByString(string $className, string|ReflectionMethod $method, ?ReflectionClass $reflection = null): void
	{
		$class = \Kiri::getDi()->get($className);
		if (is_null($reflection)) {
			$reflection = \Kiri::getDi()->getReflect($className);
		}
		$this->resolveMethod($class, $method, $reflection);
	}


	/**
	 * @param object $class
	 * @param string|ReflectionMethod $method
	 * @param ReflectionClass|null $reflection
	 * @return void
	 * @throws ReflectionException
	 */
	public function addRouteByObject(object $class, string|ReflectionMethod $method, ?ReflectionClass $reflection = null): void
	{
		if (is_null($reflection)) {
			$reflection = \Kiri::getDi()->getReflect($class::class);
		}
		$this->resolveMethod($class, $method, $reflection);
	}


	/**
	 * @param object $class
	 * @param string|ReflectionMethod $reflectionMethod
	 * @param ReflectionClass $reflectionClass
	 * @return void
	 * @throws ReflectionException
	 */
	public function resolveMethod(object $class, string|\ReflectionMethod $reflectionMethod, ReflectionClass $reflectionClass): void
	{
		if (is_string($reflectionMethod)) {
			$reflectionMethod = $reflectionClass->getMethod($reflectionMethod);
		}

		$this->resolveProperties($reflectionClass, $class);

		$parameters = $this->resolveMethodParams($reflectionMethod->getParameters());

		$handler = new Handler([$reflectionClass->getName(), $reflectionMethod->getName()], $parameters);

		ActionManager::add($reflectionClass->getName(), $reflectionMethod->getName(), $handler);
	}


	/**
	 * @param ReflectionClass $reflectionClass
	 * @param object $class
	 * @return void
	 */
	public function resolveProperties(ReflectionClass $reflectionClass, object $class): void
	{
		$properties = $reflectionClass->getProperties();
		foreach ($properties as $property) {
			$propertyAttributes = $property->getAttributes();

			foreach ($propertyAttributes as $attribute) {
				$attribute->newInstance()->dispatch($class, $property->getName());
			}
		}
	}


	/**
	 * @param array $parameters
	 * @return array
	 */
	public function resolveMethodParams(array $parameters): array
	{
		$params = [];
		foreach ($parameters as $parameter) {
			$parameterAttributes = $parameter->getAttributes();
			if (count($parameterAttributes) < 1) {
				if ($parameter->isDefaultValueAvailable()) {
					$value = $parameter->getDefaultValue();
				} else if ($parameter->getType() === null) {
					$value = $parameter->getType();
				} else {
					$value = $parameter->getType()->getName();
					if (class_exists($value) || interface_exists($value)) {
						$value = \Kiri::getDi()->get($value);
					} else {
						$value = match ($parameter->getType()) {
							'string' => '',
							'int', 'float' => 0,
							'', null, 'object', 'mixed' => NULL,
							'bool' => false,
							'default' => null
						};
					}
				}
				$params[$parameter->getName()] = $value;
			} else {
				$attribute = $parameterAttributes[0]->newInstance();

				$params[$parameter->getName()] = $attribute->dispatch();
			}
		}
		return $params;
	}


}
