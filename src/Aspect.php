<?php

namespace Kiri\Router;

/**
 *
 */
#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::TARGET_CLASS)]
class Aspect
{


	/**
	 * @param array|string $actions
	 */
	public function __construct(readonly public array|string $actions)
	{
	}

}
