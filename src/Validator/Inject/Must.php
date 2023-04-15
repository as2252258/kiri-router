<?php

namespace Kiri\Inject\Validator\Inject;


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
	 * @param string $name
	 * @return bool
	 */
	public function dispatch(string $name): bool
	{
		// TODO: Implement dispatch() method.
		return true;
	}

}
