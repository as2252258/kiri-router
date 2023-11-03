<?php

namespace Kiri\Router\Format;

use Kiri\Di\Inject\Container;
use Kiri\Router\Constrict\Stream;
use Psr\Http\Message\ResponseInterface;

class OtherFormat implements IFormat
{

    /**
     * @var ResponseInterface
     */
    #[Container(ResponseInterface::class)]
    public ResponseInterface $response;


    /**
     * @param mixed $result
     * @return ResponseInterface
     */
    public function call(mixed $result): ResponseInterface
    {
        return $this->response->withBody(new Stream($result));
    }


}