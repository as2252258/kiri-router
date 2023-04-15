<?php

namespace Kiri\Router\Interface;

use Throwable;
use Psr\Http\Message\ResponseInterface;

/**
 *
 */
interface ExceptionHandlerInterface
{


	/**
	 * @param Throwable $exception
	 * @param ResponseInterface $response
	 * @return ResponseInterface
	 */
	public function emit(Throwable $exception, ResponseInterface $response): ResponseInterface;

}
