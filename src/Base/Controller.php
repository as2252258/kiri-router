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


	/**
	 * @var Kiri\Router\Request
	 */
	#[Service('request')]
	public RequestInterface $request;


	/**
	 * @var Kiri\Router\Response
	 */
	#[Service('response')]
	public ResponseInterface $response;


	/**
	 * @var LoggerInterface
	 */
	#[Container(LoggerInterface::class)]
	public LoggerInterface $logger;


	/**
	 * @var ContainerInterface
	 */
	#[Container(ContainerInterface::class)]
	public ContainerInterface $container;
}
