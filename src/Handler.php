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
