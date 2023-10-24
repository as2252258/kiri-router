<?php

namespace Kiri\Router\Format;

use Psr\Http\Message\ResponseInterface;

class ResponseFormat implements IFormat
{

    /**
     * @param $result
     * @return ResponseInterface
     */
    public function call($result): ResponseInterface
    {
        // TODO: Implement call() method.
        return $result;
    }
}