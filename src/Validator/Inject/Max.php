<?php

namespace Kiri\Inject\Validator\Inject;


#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Max implements ValidatorInterface
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
