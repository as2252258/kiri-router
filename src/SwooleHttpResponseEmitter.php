<?php
declare(strict_types=1);

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


/**
 * Swoole Http Response Emitter
 */
class SwooleHttpResponseEmitter implements ResponseEmitterInterface
{

    /**
     * @var SplPriorityQueue
     */
    protected SplPriorityQueue $events;


    /**
     * @var OnAfterRequest
     */
    protected OnAfterRequest $afterRequest;


    /**
     * @param EventDispatch $dispatch
     * @param EventProvider $provider
     */
    public function __construct(readonly public EventDispatch $dispatch, readonly public EventProvider $provider)
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
    public function response(ResponseInterface $proxy, object $response, object $request): void
    {
        // TODO: Implement sender() method.
        $this->writeParams($proxy, $response, $request);

        $proxy->end($response);

        $this->dispatch->execute($this->events, $this->afterRequest);
    }


    /**
     * @param Response $proxy
     * @param object $response
     * @param object $request
     * @return void
     */
    private function writeParams(ResponseInterface $proxy, object $response, object $request): void
    {
        $response->setStatusCode($proxy->getStatusCode());
        $headers = $proxy->getHeaders();
        if (count($headers) > 0) foreach ($headers as $name => $header) {
            $response->header($name, $header);
        }
        $cookieParams = $proxy->getCookieParams();
        if (count($cookieParams) > 0) foreach ($cookieParams as $cookie) {
            $response->setCookie(...$cookie);
        }
        $response->header('Run-Time', $this->getRunTime($request));
        $response->header('Server', 'swoole');
        $response->header('Swoole-Version', \swoole_version());
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
