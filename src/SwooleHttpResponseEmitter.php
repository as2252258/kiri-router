<?php
declare(strict_types=1);

namespace Kiri\Router;

use Exception;
use Kiri\Di\Interface\ResponseEmitterInterface;
use Kiri\Server\Events\OnAfterRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;


class SwooleHttpResponseEmitter implements ResponseEmitterInterface
{


    /**
     * @param Response $proxy
     * @param object $response
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
	public function sender(ResponseInterface $proxy, object $response): void
	{
		// TODO: Implement sender() method.
		$this->writeParams($proxy, $response);

		$proxy->end($response);

        event(new OnAfterRequest());
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

        $request = \request();

		$response->header('Run-Time', microtime(true) - +$request->getServerParam('request_time_float'));
		$response->header('Server', 'swoole');
		$response->header('Swoole-Version', swoole_version());
	}


}
