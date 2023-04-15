<?php

namespace Kiri\Inject\Route;


#[\Attribute(\Attribute::TARGET_PARAMETER)]
class QueryData
{

	/**
	 * @param array $rule
	 */
	public function __construct(readonly public array $rule)
	{
	}

}
