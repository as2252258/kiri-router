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


/**
 * Swoole Http Response Emitter
 */
class SwooleHttpResponseEmitter implements ResponseEmitterInterface
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
        $this->writeParams($proxy, $response, $request);

        $proxy->end($response);

        event(new OnAfterRequest());
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
        $response->header('Swoole-Version', swoole_version());
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
