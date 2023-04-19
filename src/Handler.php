<?php
declare(strict_types=1);

namespace Kiri\Router;

use Closure;
use Kiri\Di\Context;
use Kiri\Router\Base\Controller;
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
		if (is_array($this->handler)) {
			[$controller, $action, $parameter] = [...$this->handler, $this->parameter];
			$this->handler = static function (RequestInterface $request) use ($controller, $action, $parameter) {
				/** @var Controller $controller */
				if ($controller->beforeAction($request)) {
					$response = call_user_func([$controller, $action], ...$parameter);
					$controller->afterAction($response);
					return $response;
				} else {
					/** @var Response $response */
					$response = \Kiri::service()->get('response');
					return $response->withStatus(500, 'BeforeAction error');
				}
			};
			$this->parameter = [$this->request];
		}
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
		return call_user_func($this->handler, ...$this->parameter);
	}

}
