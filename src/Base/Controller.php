<?php
declare(strict_types=1);

namespace Kiri\Router\Base;


use Kiri;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Kiri\Di\Inject\Service;
use Kiri\Di\Inject\Container;

/**
 * Class WebController
 * @package Kiri\Web
 */
abstract class Controller
{

	#[Service('request')]
	public RequestInterface $request;

	#[Service('response')]
	public ResponseInterface $response;


	#[Container(LoggerInterface::class)]
	public LoggerInterface $logger;


	#[Container(ContainerInterface::class)]
	public ContainerInterface $container;
}
