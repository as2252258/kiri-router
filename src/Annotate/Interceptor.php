<?php
declare(strict_types=1);

namespace Kiri\Router\Annotate;


use Kiri\Di\Interface\InjectMethodInterface;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Interceptor implements InjectMethodInterface
{

    public function __construct()
    {
    }


    /**
     * @param string $class
     * @param string $method
     * @return void
     */
    public function dispatch(string $class, string $method): void
    {
        // TODO: Implement dispatch() method.
    }

}
