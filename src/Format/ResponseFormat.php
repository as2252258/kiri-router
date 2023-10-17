<?php

namespace Kiri\Router\Format;

use Psr\Http\Message\ResponseInterface;

class ResponseFormat implements IFormat
{

    /**
     * @inheritDoc
     */
    public function call($result): ResponseInterface
    {
        // TODO: Implement call() method.
        return $result;
    }
}