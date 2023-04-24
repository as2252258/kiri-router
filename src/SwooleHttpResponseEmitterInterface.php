<?php
declare(strict_types=1);

namespace Kiri\Router;

use Exception;
use Kiri\Di\Interface\ResponseEmitterInterface;
use Psr\Http\Message\ResponseInterface;


class SwooleHttpResponseEmitterInterface implements ResponseEmitterInterface
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

		$proxy->end($response);
	}


	/**
	 * @param Response $proxy
	 * @param object $response
	 * @return void
	 */
	private function writeParams(ResponseInterface $proxy, object $response): void
	{
		$response->setStatusCode($proxy->getStatusCode());
		foreach ($proxy->getHeaders() as $name => $header) {
			$response->header($name, $header);
		}
		foreach ($proxy->getCookieParams() as $cookie) {
			$response->setCookie(...$cookie);
		}
		$response->header('Server', 'swoole');
		$response->header('Swoole-Version', swoole_version());
	}


}
