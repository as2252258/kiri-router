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
use Kiri\Di\Inject\Service;
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
	 * @var Request
	 */
	#[Service('request')]
	public RequestInterface $request;


	/**
	 * @var Response
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
