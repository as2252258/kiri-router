<?php
declare(strict_types=1);

namespace Kiri\Router\Validator\Inject;

use Kiri\Router\Interface\ValidatorInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Email implements ValidatorInterface
{


	/**
	 * @return string
	 */
	public function getError(): string
	{
		return '';
	}


	/**
	 * @param object $class
	 * @param string $name
	 * @return bool
	 */
	public function dispatch(object $class, string $name): bool
	{
		return filter_var($class->{$name}, FILTER_VALIDATE_EMAIL);
	}
}
