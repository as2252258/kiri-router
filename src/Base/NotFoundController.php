<?php
declare(strict_types=1);

namespace Kiri\Router\Base;


use Psr\Http\Message\ResponseInterface;

class NotFoundController extends Controller
{


    /**
     * @return ResponseInterface
     */
    public function fail(): ResponseInterface
    {
        if ($this->request->getMethod() == 'OPTIONS') {
            return $this->response->withStatus(200, "");
        }
        return $this->response->withStatus(404, "not found page.");
    }

}
