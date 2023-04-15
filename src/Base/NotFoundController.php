<?php

namespace Kiri\Router\Base;

use Kiri\Message\Constrict\ResponseInterface;

class NotFoundController extends Controller
{


	/**
	 * @return ResponseInterface
	 */
	public function fail(): ResponseInterface
	{
		return $this->response->failure(404, "not found page.");
	}

}
