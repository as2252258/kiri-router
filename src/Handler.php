<?php
declare(strict_types=1);

namespace Kiri\Router;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReflectionException;

class Handler implements RequestHandlerInterface
{


	/**
	 * @param array|\Closure $handler
	 * @param array $parameter
	 */
	public function __construct(public array|\Closure $handler, public array $parameter)
	{
	}


	/**
	 * @return bool
	 */
	public function isClosure(): bool
	{
		return $this->handler instanceof \Closure;
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
		$result = call_user_func($this->handler, ...$this->parameter);
		if ($result instanceof ResponseInterface) {
			return $result;
		} else {
			$response = \Kiri::getDi()->get(ResponseInterface::class);
			return $response->rewrite();
		}
	}

}
