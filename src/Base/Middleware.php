<?php
declare(strict_types=1);

namespace Kiri\Router\Base;

use Kiri;
use Psr\Http\Server\MiddlewareInterface;

class Middleware
{


    /**
     * @var array
     */
    protected static array $manager = [];


    protected static array $mapping = [];


    /**
     * @param string $className
     * @param string $method
     * @param string $middleware
     * @return void
     * @throws
     */
    public static function set(string $className, string $method, string $middleware): void
    {
        $path = $className . '::' . $method;
        if (!isset(static::$manager[$path])) {
            static::$manager[$path] = static::$mapping[$path] = [];
        }
        if (!in_array($middleware, static::$mapping[$path])) {
            static::$manager[$path][] = Kiri::getDi()->get($middleware);
            static::$mapping[$path][] = $middleware;
        }
    }


    /**
     * @param string $className
     * @param string $method
     * @return array
     */
    public static function get(string $className, string $method): array
    {
        return static::$manager[$className . '::' . $method] ?? [];
    }


}
