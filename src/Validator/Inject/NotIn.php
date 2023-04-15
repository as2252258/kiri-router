<?php

namespace Kiri\Inject\Validator\Inject;


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
	 * @param string $name
	 * @return bool
	 */
	public function dispatch(string $name): bool
	{
		// TODO: Implement dispatch() method.
		return true;
	}
}
