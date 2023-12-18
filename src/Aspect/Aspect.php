<?php

namespace Kiri\Router\Aspect;


use Kiri\Di\Interface\InjectMethodInterface;
use PhpParser\ParserFactory;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Aspect implements InjectMethodInterface
{


    /**
     * @param array|string $aspect
     */
    public function __construct(readonly public array|string $aspect = [])
    {
    }


    /**
     * @param string $class
     * @param string $method
     * @return void
     */
    public function dispatch(string $class, string $method): void
    {
    }

}
