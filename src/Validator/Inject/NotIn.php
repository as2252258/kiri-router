<?php
declare(strict_types=1);

namespace Kiri\Router\Validator\Inject;

use Kiri\Router\Interface\ValidatorInterface;


#[\Attribute(\Attribute::TARGET_PROPERTY)]
class NotIn implements ValidatorInterface
{


	/**
	 * @param array $value
	 */
	public function __construct(readonly public array $value)
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
		return !in_array($class->{$name}, $this->value);
	}
}
