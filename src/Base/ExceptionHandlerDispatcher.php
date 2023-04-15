<?php

namespace Kiri\Message;


use Kiri\Message\Constrict\Response;
use Kiri\Message\Constrict\ResponseInterface;
use Kiri\Message\Abstracts\ExceptionHandlerInterface;
use Throwable;


/**
 *
 */
class ExceptionHandlerDispatcher implements ExceptionHandlerInterface
{


	/**
	 * @param Throwable $exception
	 * @param Response $response
	 * @return ResponseInterface
	 */
	public function emit(Throwable $exception, Response $response): ResponseInterface
	{
		$response->withContentType(ContentType::HTML);
		if ($exception->getCode() == 404) {
			return $response->withBody(new Stream($exception->getMessage()))->withStatus(404);
		}
		return $response->withBody(new Stream(jTraceEx($exception, null, true)))
			->withStatus($exception->getCode() == 0 ? 500 : $exception->getCode());
	}

}
