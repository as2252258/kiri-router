<?php
declare(strict_types=1);

namespace Kiri\Router\Base;


use Psr\Http\Message\ResponseInterface;

class MethodErrorController extends Controller
{


	/**
	 * @return ResponseInterface
	 */
	public function fail(): ResponseInterface
	{
		return $this->response->withStatus(405, "method allow.");
	}
}
