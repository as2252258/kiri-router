<?php
declare(strict_types=1);

namespace Kiri\Router\Base;


use Kiri;
use Kiri\Router\Response;
use Kiri\Router\Request;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Kiri\Di\Inject\Container;

/**
 * Class WebController
 * @package Kiri\Web
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
     * @var Kiri\Error\StdoutLogger
     */
    #[Container(LoggerInterface::class)]
    public Kiri\Error\StdoutLogger $logger;


    /**
     * @param Request $request
     * @return true
     */
    public function beforeAction(RequestInterface $request): bool
    {
        return true;
    }

}
