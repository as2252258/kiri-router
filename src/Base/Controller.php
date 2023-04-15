<?php
declare(strict_types=1);

namespace Kiri\Router\Base;


use Kiri;
use Kiri\Di\ContainerInterface;
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
	readonly public RequestInterface $request;

	#[Service('response')]
	readonly public ResponseInterface $response;


	#[Container(LoggerInterface::class)]
	readonly public LoggerInterface $logger;


	#[Container(ContainerInterface::class)]
	readonly public ContainerInterface $container;
}
