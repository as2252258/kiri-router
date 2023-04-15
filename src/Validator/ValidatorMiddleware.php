<?php

namespace Kiri\Router\Validator;

use Kiri\Di\Context;
use Kiri\Router\Constrict\Stream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ValidatorMiddleware implements MiddlewareInterface
{


	/**
	 * @param Validator $validator
	 */
	public function __construct(readonly public Validator $validator)
	{
	}


	/**
	 * @param ServerRequestInterface $request
	 * @param RequestHandlerInterface $handler
	 * @return ResponseInterface
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		try {
			$this->validator->bindData($request);
			return $handler->handle($request);
		} catch (\Throwable $throwable) {
			/** @var ResponseInterface $response */
			$response = Context::get(ResponseInterface::class);
			$response->withStatus(407)->withBody(new Stream($throwable->getMessage()));
			return $response;
		}
	}

}
