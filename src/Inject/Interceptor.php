<?php
declare(strict_types=1);

namespace Kiri\Router\Inject;


#[\Attribute(\Attribute::TARGET_METHOD)]
class Interceptor
{

	public function __construct()
	{
	}

}
