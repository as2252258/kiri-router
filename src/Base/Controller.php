<?php
declare(strict_types=1);

namespace Kiri\Router\Base;


use Kiri;
use Kiri\Router\Response;
use Kiri\Router\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Kiri\Di\Inject\Container;
use ReflectionException;
use Kiri\Error\StdoutLogger;

/**
 * Class WebController
 * @package Kiri\Web
 * @property-read ContainerInterface $container
 * @property-read LoggerInterface $logger
 */
abstract class Controller
{


    /**
     * @var Request
     */
    #[Container(RequestInterface::class)]
    public RequestInterface $request;


    /**
     * @var Response
     */
    #[Container(ResponseInterface::class)]
    public ResponseInterface $response;


    /**
     * @var ContainerInterface
     */
    #[Container(ContainerInterface::class)]
    public ContainerInterface $container;


    /**
     * @return StdoutLogger
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getLogger(): StdoutLogger
    {
        return $this->container->get(LoggerInterface::class);
    }


    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        // TODO: Implement __get() method.
        return $this->{'get' . ucfirst($name)}();
    }


    /**
     * @param Request $request
     * @return true
     */
    public function beforeAction(RequestInterface $request): bool
    {
        return true;
    }


    /**
     * @param Response $response
     * @return void
     */
    public function afterAction(ResponseInterface $response): void
    {
    }


}
