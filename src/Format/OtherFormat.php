<?php

namespace Kiri\Router\Format;

use Kiri\Router\Constrict\Stream;
use Psr\Http\Message\ResponseInterface;

class OtherFormat implements IFormat
{


    /**
     * @param mixed $result
     * @return ResponseInterface
     */
    public function call(mixed $result): ResponseInterface
    {
        return \response()->withBody(new Stream($result));
    }


}