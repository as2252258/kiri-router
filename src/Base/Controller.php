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
use ReflectionException;

/**
 * Class WebController
 * @package Kiri\Web
 * @property-read ContainerInterface $container
 * @property-read LoggerInterface $logger
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
	 * @return ContainerInterface
	 */
	private function getContainer(): ContainerInterface
	{
		return Kiri::getDi();
	}


	/**
	 * @return LoggerInterface
	 * @throws ReflectionException
	 */
	private function getLogger(): LoggerInterface
	{
		return Kiri::getDi()->get(LoggerInterface::class);
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


}
