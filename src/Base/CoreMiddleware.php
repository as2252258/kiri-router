<?php
declare(strict_types=1);

namespace Kiri\Router\Base;

use Exception;
use Kiri\Router\Request;
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
	 * @param Request $request
	 * @param RequestHandlerInterface $handler
	 * @return ResponseInterface
	 * @throws Exception
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		response()->withHeaders([
			'Access-Control-Allow-Headers'  => '*',
			'Access-Control-Request-Method' => '*',
			'Access-Control-Allow-Origin'   => '*'
		]);
		return $handler->handle($request);
	}

}
