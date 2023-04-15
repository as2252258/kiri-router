<?php
declare(strict_types=1);

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
	 * @param \Swoole\Http\Response $response
	 * @return void
	 * @throws Exception
	 */
	private function writeParams(ResponseInterface $proxy, object $response): void
	{
		$response->setStatusCode($proxy->getStatusCode());
		/** @var Response $resp */
		$resp = \Kiri::service()->get('response');
		foreach ($resp->getHeaders() as $name => $header) {
			$response->header($name, implode(', ', $header));
		}
		foreach ($resp->getCookieParams() as $cookie) {
			$response->setCookie(...$cookie);
		}
		$response->header('Server', 'swoole');
		$response->header('Swoole-Version', swoole_version());
	}


}
