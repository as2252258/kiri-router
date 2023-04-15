<?php

namespace Kiri\Router\Base;

use Exception;
use Kiri\Router\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 *
 */
class CoreMiddleware implements MiddlewareInterface
{


	/**
	 * @param ServerRequest $request
	 * @param RequestHandlerInterface $handler
	 * @return ResponseInterface
	 * @throws Exception
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		/** @var ResponseInterface $response */
		$response = \Kiri::service()->get('response');
		$response->withHeader('Access-Control-Allow-Headers', $request->header('Access-Control-Allow-Headers'))
			->withHeader('Access-Control-Request-Method', $request->header('Access-Control-Allow-Origin'))
			->withHeader('Access-Control-Allow-Origin', $request->header('Access-Control-Allow-Headers'));
		return $handler->handle($request);
	}

}
