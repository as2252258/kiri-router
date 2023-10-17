<?php

namespace Kiri\Router;

use Kiri\Di\Inject\Container;
use Kiri\Di\Interface\ResponseEmitterInterface;
use Kiri\Events\EventDispatch;
use Kiri\Events\EventProvider;
use Kiri\Server\Events\OnAfterRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use SplPriorityQueue;

class SwowHttpResponseEmitter implements ResponseEmitterInterface
{

    /**
     * @var EventProvider
     */
    #[Container(EventProvider::class)]
    public EventProvider $provider;


    /**
     * @var EventDispatch
     */
    #[Container(EventDispatch::class)]
    public EventDispatch $dispatch;


    /**
     * @var SplPriorityQueue
     */
    protected SplPriorityQueue $events;


    /**
     * @var OnAfterRequest
     */
    protected OnAfterRequest $afterRequest;


    /**
     * @return void
     */
    public function init(): void
    {
        $this->afterRequest = new OnAfterRequest();
        $this->events       = $this->provider->getListenersForEvent($this->afterRequest);
    }


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

        $this->dispatch->execute($this->events, $this->afterRequest);
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
