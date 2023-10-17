<?php

namespace Kiri\Router\Format;

use Psr\Http\Message\ResponseInterface;

interface IFormat
{

    /**
     * @param $result
     * @return ResponseInterface
     */
    public function call($result): ResponseInterface;

}