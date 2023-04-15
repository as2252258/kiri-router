<?php
declare(strict_types=1);

namespace Kiri\Router\Validator\Inject;

use Kiri\Router\Interface\ValidatorInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class NotNull implements ValidatorInterface
{


	/**
	 * @param object $class
	 * @param string $name
	 * @return bool
	 */
	public function dispatch(object $class, string $name): bool
	{
		// TODO: Implement dispatch() method.
		return $class->{$name} !== null;
	}
}
