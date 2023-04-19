<?php
declare(strict_types=1);

namespace Kiri\Router;

use Closure;
use Kiri\Di\Context;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReflectionException;

class Handler implements RequestHandlerInterface
{


	/**
	 * @var RequestInterface|mixed|null
	 */
	private RequestInterface $request;

	/**
	 * @param array|Closure $handler
	 * @param array $parameter
	 * @throws
	 */
	public function __construct(public array|Closure $handler, public array $parameter)
	{
		$this->request = \Kiri::service()->get('request');
	}


	/**
	 * @return bool
	 */
	public function isClosure(): bool
	{
		return $this->handler instanceof Closure;
	}


	/**
	 * @return string|null
	 */
	public function getClass(): ?string
	{
		if ($this->isClosure()) {
			return null;
		}
		return $this->handler[0]::class;
	}


	/**
	 * @return string|null
	 */
	public function getMethod(): ?string
	{
		if ($this->isClosure()) {
			return null;
		}
		return $this->handler[1];
	}


	/**
	 * @param ServerRequestInterface $request
	 * @return ResponseInterface
	 * @throws ReflectionException
	 */
	public function handle(ServerRequestInterface $request): ResponseInterface
	{
		// TODO: Implement handle() method.
		if ($this->handler instanceof Closure) {
			return call_user_func($this->handler, ...$this->parameter);
		}
		[$controller, $action] = $this->handler;
		if ($controller->beforeAction($this->request)) {
			$response = call_user_func($this->handler, ...$this->parameter);
	        $controller->afterAction($response);
		} else {
			/** @var Response $response */
			$response = \Kiri::service()->get('response');
			$response->withStatus(500,'BeforeAction error');
		}
		return $response;
	}

}
