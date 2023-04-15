<?php
declare(strict_types=1);

namespace Kiri\Router\Inject;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Aspect
{


	/**
	 * @param string $aspect
	 */
	public function __construct(readonly public string $aspect)
	{
	}

}
