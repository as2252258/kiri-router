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
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
	public function sender(ResponseInterface $proxy, object $response): void
	{
		// TODO: Implement sender() method.
		$proxy->withHeader('Server', 'Swow');
		$response->sendHttpResponse($proxy);

        event(new OnAfterRequest());
    }

}
