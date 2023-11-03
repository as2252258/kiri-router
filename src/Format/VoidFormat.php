<?php

namespace Kiri\Router\Format;

use Kiri\Di\Inject\Container;
use Psr\Http\Message\ResponseInterface;

class VoidFormat implements IFormat
{


    /**
     * @var ResponseInterface
     */
    #[Container(ResponseInterface::class)]
    public ResponseInterface $response;



    /**
     * @param $result
     * @return ResponseInterface
     */
    public function call($result): ResponseInterface
    {
        // TODO: Implement call() method.
        return $this->response;
    }

}