<?php
declare(strict_types=1);

namespace Kiri\Router;

use Kiri;
use ReflectionException;

class DataGrip
{

	private array $servers = [];


	/**
	 * @param $type
	 * @return RouterCollector
	 * @throws ReflectionException
	 */
	public function get($type): RouterCollector
	{
		if (!isset($this->servers[$type])) {
			$this->servers[$type] = Kiri::getDi()->make(RouterCollector::class);
		}
		return $this->servers[$type];
	}


}
