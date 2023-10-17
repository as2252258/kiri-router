<?php

namespace Kiri\Router;

use Kiri\Di\Interface\ResponseEmitterInterface;
use Kiri\Server\Events\OnAfterRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;

class SwowHttpResponseEmitter implements ResponseEmitterInterface
{


    /**
     * @param Response $proxy
     * @param object $response
     * @param object $request
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
	public function sender(ResponseInterface $proxy, object $response, object $request): void
	{
		// TODO: Implement sender() method.
		$proxy->withHeader('Server', 'Swow');
        $proxy->withHeader('Run-Time', $this->getRunTime($request));
        $response->sendHttpResponse($proxy);

        event(new OnAfterRequest());
    }


    /**
     * @param object $request
     * @return float
     */
    protected function getRunTime(object $request): float
    {
        return microtime(true) - +$request->getServerParam('request_time_float');
    }

}
