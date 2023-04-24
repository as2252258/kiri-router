<?php
declare(strict_types=1);

namespace Kiri\Router\Base;


use Kiri\Router\ContentType;
use Kiri\Router\Interface\ExceptionHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;
use Kiri\Router\Constrict\Stream;


/**
 *
 */
class ExceptionHandlerDispatcher implements ExceptionHandlerInterface
{


	/**
	 * @param Throwable $exception
	 * @param object $response
	 * @return ResponseInterface
	 * @throws
	 */
	public function emit(Throwable $exception, object $response): ResponseInterface
	{
		error($exception);
		$response->withContentType(ContentType::HTML)->withBody(new Stream(jTraceEx($exception, null, true)));
		if ($exception->getCode() == 404) {
			return $response->withStatus(404);
		} else {
			return $response->withStatus($exception->getCode() == 0 ? 500 : $exception->getCode());
		}
	}

}
