<?php
declare(strict_types=1);

namespace Kiri\Router\Annotate;


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
