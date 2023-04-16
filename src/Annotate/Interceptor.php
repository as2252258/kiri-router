<?php
declare(strict_types=1);

namespace Kiri\Router\Annotate;


#[\Attribute(\Attribute::TARGET_METHOD)]
class Interceptor
{

	public function __construct()
	{
	}

}
