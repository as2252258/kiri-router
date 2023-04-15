<?php
declare(strict_types=1);

namespace Kiri\Router\Validator\Inject;

use Kiri\Router\Interface\ValidatorInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Round implements ValidatorInterface
{


	/**
	 * @param int $value
	 */
	public function __construct(readonly public int $value)
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
		return round($class->$name, $this->value) === $class->$name;
	}
}
