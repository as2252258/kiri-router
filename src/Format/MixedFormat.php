<?php

namespace Kiri\Router\Format;

use Kiri\Router\Constrict\Stream;
use Kiri\Router\ContentType;
use Psr\Http\Message\ResponseInterface;

class MixedFormat implements IFormat
{


    /**
     * @param mixed $result
     * @return ResponseInterface
     */
    public function call(mixed $result): ResponseInterface
    {
        if (is_object($result)) {
            return \response()->withBody(new Stream('[object]'));
        }
        if (is_array($result)) {
            return \response()->withContentType(ContentType::JSON)->withBody(new Stream(json_encode($result, JSON_UNESCAPED_UNICODE)));
        } else {
            return \response()->withBody(new Stream($result));
        }
    }


}