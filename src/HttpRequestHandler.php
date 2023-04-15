<?php
declare(strict_types=1);

namespace Kiri\Router;

use Kiri\Router\Base\AbstractHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReflectionException;

class HttpRequestHandler extends AbstractHandler implements RequestHandlerInterface
{


	/**
	 * @param ServerRequestInterface $request
	 * @return ResponseInterface
	 * @throws ReflectionException
	 */
	public function handle(ServerRequestInterface $request): ResponseInterface
	{
		// TODO: Implement handle() method.
		return $this->execute($request);
	}


}
