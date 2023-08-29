<?php
declare(strict_types=1);

namespace Kiri\Router\Base;

use Exception;
use Kiri\Core\HashMap;
use Psr\Http\Server\MiddlewareInterface;

class Middleware
{


    /**
     * @var array
     */
    protected array $manager = [];


    /**
     *
     */
    public function __construct()
    {
    }


    /**
     * @param string $className
     * @param string $method
     * @param string|object $middleware
     * @return void
     * @throws Exception
     */
    public function set(string $className, string $method, string|object $middleware): void
    {
        $path = $className . '::' . $method;
        if (isset($this->manager[$path])) {
            $values = $this->manager[$path];
            if (in_array($middleware, $values)) {
                return;
            }
            if (!in_array(MiddlewareInterface::class, class_implements($middleware))) {
                return;
            }
        } else {
            $this->manager[$path] = [];
        }
        $this->manager[$path][] = $middleware;
    }


    /**
     * @param string $className
     * @param string $method
     * @return array
     */
    public function get(string $className, string $method): array
    {
        return $this->manager[$className . '::' . $method] ?? [];
    }


}
