<?php

namespace Kiri\Router\Validator\Inject;

use Kiri\Router\Interface\ValidatorInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class NotEmpty implements ValidatorInterface
{

	/**
	 * @param object $class
	 * @param string $name
	 * @return bool
	 */
	public function dispatch(object $class, string $name): bool
	{
		// TODO: Implement dispatch() method.
		return !empty($class->{$name});
	}
}
