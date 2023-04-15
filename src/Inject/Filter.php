<?php
declare(strict_types=1);

namespace Kiri\Router\Inject;


#[\Attribute(\Attribute::TARGET_METHOD)]
class Filter
{

	public function __construct()
	{
	}

}
