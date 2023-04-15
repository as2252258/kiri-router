<?php

namespace Kiri\Inject\Validator\Inject;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class MinLength implements ValidatorInterface
{


	/**
	 * @param int $value
	 */
	public function __construct(readonly public int $value)
	{
	}


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
