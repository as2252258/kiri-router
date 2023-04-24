<?php

namespace Kiri\Router;

use Kiri\Di\Interface\ResponseEmitterInterface;
use Psr\Http\Message\ResponseInterface;

class SwowHttpResponseEmitterInterface implements ResponseEmitterInterface
{


	/**
	 * @param Response $proxy
	 * @param object $response
	 * @return void
	 */
	public function sender(ResponseInterface $proxy, object $response): void
	{
		// TODO: Implement sender() method.
		$proxy->withHeader('Server', 'Swow');
		$response->sendHttpResponse($proxy);
	}

}
