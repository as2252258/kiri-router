<?php

namespace Kiri\Router;

class ChunkResponse extends Response
{

	public int $limit;


	/**
	 * @param object $response
	 * @return void
	 */
	public function write(object $response): void
	{
		$body = $this->getBody();
		$total = ceil($this->limit / $body->getSize());

		for ($i = 0; $i < $total; $i++) {
			$body->seek($i);

			$response->write($body->read($this->limit));
		}
		$response->end();
	}
}
