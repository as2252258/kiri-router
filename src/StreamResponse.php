<?php
declare(strict_types=1);

namespace Kiri\Router;


use Kiri\Server\Events\OnAfterRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

/**
 *
 */
class StreamResponse extends Response
{

	public int $limit;


    /**
     * @param object $response
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
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
//        event(new OnAfterRequest());
	}

}
