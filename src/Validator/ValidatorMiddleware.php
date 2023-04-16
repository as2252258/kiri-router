<?php
declare(strict_types=1);

namespace Kiri\Router\Validator;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 *
 */
class ValidatorMiddleware implements MiddlewareInterface
{


	readonly public Validator $validator;



	/**
	 * @param ServerRequestInterface $request
	 * @param RequestHandlerInterface $handler
	 * @return ResponseInterface
	 * @throws Exception
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		$this->validator->bindData($request);

		return $handler->handle($request);
	}
}
