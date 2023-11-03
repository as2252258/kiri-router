<?php

namespace Kiri\Router\Format;

use Kiri\Di\Inject\Container;
use Kiri\Router\Constrict\Stream;
use Psr\Http\Message\ResponseInterface;

class ArrayFormat implements IFormat
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
        return $this->response->withBody(new Stream(json_encode($result, JSON_UNESCAPED_UNICODE)));
    }


}