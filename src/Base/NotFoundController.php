<?php
declare(strict_types=1);

namespace Kiri\Router\Base;


use Kiri\Di\Context;
use Psr\Http\Message\ResponseInterface;

class NotFoundController extends Controller
{


    /**
     * @return ResponseInterface
     */
    public function fail(): ResponseInterface
    {
        $response = Context::get(ResponseInterface::class);
        if ($this->request->getMethod() == 'OPTIONS') {
            return $response->withStatus(200, "");
        } else {
            return $response->withStatus(404, "not found page.");
        }
    }

}
