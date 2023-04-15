<?php

namespace Kiri\Message\Handler;

use Kiri;

class DataGrip
{

	private array $servers = [];


	/**
	 * @param $type
	 * @return RouterCollector
	 */
	public function get($type): RouterCollector
	{
		if (!isset($this->servers[$type])) {
			$this->servers[$type] = Kiri::getDi()->create(RouterCollector::class);
		}
		return $this->servers[$type];
	}


}
