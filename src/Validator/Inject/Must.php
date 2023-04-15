<?php

namespace Kiri\Router\Validator\Inject;


use Kiri\Router\Interface\ValidatorInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Must implements ValidatorInterface
{


	/**
	 * @param mixed $value
	 */
	public function __construct(readonly public mixed $value)
	{
	}


	/**
	 * @param object $class
	 * @param string $name
	 * @return bool
	 */
	public function dispatch(object $class, string $name): bool
	{
		// TODO: Implement dispatch() method.
		return $class->{$name} === $this->value;
	}

}
