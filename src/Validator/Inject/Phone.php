<?php

namespace Kiri\Router\Validator\Inject;

use Kiri\Router\Interface\ValidatorInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Phone implements ValidatorInterface
{
	const REG = '/^1[356789]\d{9}$/';

	/**
	 * @param object $class
	 * @param string $name
	 * @return bool
	 */
	public function dispatch(object $class, string $name): bool
	{
		return preg_match(self::REG, $class->{$name});
	}
}
