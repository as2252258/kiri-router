<?php

namespace Kiri\Router\Format;

use Kiri\Router\Constrict\Stream;
use Kiri\Router\ContentType;
use Psr\Http\Message\ResponseInterface;

class ArrayFormat implements IFormat
{


    /**
     * @param $result
     * @return ResponseInterface
     */
    public function call($result): ResponseInterface
    {
        $result = json_encode($result);

        return \response()->withBody(new Stream(json_encode($result, JSON_UNESCAPED_UNICODE)));
    }


}