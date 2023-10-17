<?php

namespace Kiri\Router\Format;

use Psr\Http\Message\ResponseInterface;

class VoidFormat implements IFormat
{


    /**
     * @param $result
     * @return ResponseInterface
     */
    public function call($result): ResponseInterface
    {
        // TODO: Implement call() method.
        return response();
    }

}