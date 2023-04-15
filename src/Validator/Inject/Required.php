<?php

namespace Kiri\Inject\Validator\Inject;


#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Required implements ValidatorInterface
{


	public function dispatch(string $name): bool
	{
		// TODO: Implement dispatch() method.
		return true;
	}

}
