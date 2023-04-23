<?php
declare(strict_types=1);

namespace Kiri\Router;

use Psr\Http\Message\ResponseInterface;

class StreamResponse extends Response
{

	public int $limit;


	/**
	 * @param object $response
	 * @return void
	 */
	public function end(object $response): void
	{
		$body = $this->getBody();
		$total = ceil($this->limit / $body->getSize());
		$response->header('Content-Length', [$body->getSize()]);
		for ($i = 0; $i < $total; $i++) {
			$body->seek($i);

			$response->write($body->read($this->limit));
		}
		$response->end();
	}

}
