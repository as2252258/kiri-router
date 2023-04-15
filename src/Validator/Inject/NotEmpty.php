<?php

namespace Kiri\Inject\Validator\Inject;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class NotEmpty implements ValidatorInterface
{

	/**
	 * @param string $name
	 * @return bool
	 */
	public function dispatch(string $name): bool
	{
		// TODO: Implement dispatch() method.
		return true;
	}
}
