<?php

namespace Kiri\Router\Format;

use Kiri\Router\Constrict\Stream;
use Psr\Http\Message\ResponseInterface;

class NoBody implements IFormat
{


    /**
     * @param $result
     * @return ResponseInterface
     */
    public function call($result): ResponseInterface
    {
        // TODO: Implement call() method.
        if ($result instanceof ResponseInterface) {
            $result->getBody()->write('');
        } else {
            $result = response()->withBody(new Stream());
        }
        return $result;
    }
}