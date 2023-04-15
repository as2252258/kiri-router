<?php

namespace Kiri\Router;

use Exception;
use Kiri\Di\Interface\ResponseEmitter;
use Psr\Http\Message\ResponseInterface;


class HttpResponseEmitter implements ResponseEmitter
{


	/**
	 * @param Response $proxy
	 * @param object $response
	 * @return void
	 * @throws Exception
	 */
	public function sender(ResponseInterface $proxy, object $response): void
	{
		// TODO: Implement sender() method.
		$this->writeParams($proxy, $response);

		$proxy->write($response);
	}


	/**
	 * @param Response $proxy
	 * @param object $response
	 * @return void
	 * @throws Exception
	 */
	private function writeParams(ResponseInterface $proxy, object $response): void
	{
		$response->setStatusCode($proxy->getStatusCode());
		/** @var ServerRequest $request */
		$request = \Kiri::service()->get('request');
		foreach ($request->getHeaders() as $name => $header) {
			$response->header($name, implode(', ', $header));
		}

		$response->setStatusCode($proxy->getStatusCode());
		foreach ($request->getCookieParams() as $cookie) {
			$response->setCookie(...$cookie);
		}
		$response->header('Server', 'swoole');
		$response->header('Swoole-Version', swoole_version());
	}


}
