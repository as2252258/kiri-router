<?php
declare(strict_types=1);

namespace Kiri\Router\Annotate;

use Kiri;
use Kiri\Router\Constrict\RequestMethod;
use Kiri\Di\Interface\InjectMethodInterface;
use Kiri\Router\Router;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Head extends AbstractRequestMethod implements InjectMethodInterface
{


    /**
     * @param string $path
     * @param string $version
     */
    public function __construct(readonly public string $path, readonly public string $version = '')
    {
    }


    /**
     * @param string $class
     * @param string $method
     * @return void
     */
    public function dispatch(string $class, string $method): void
    {
        $controller = Kiri::getDi()->get($class);
        // TODO: Implement dispatch() method.
        $path = '/' . ltrim($this->path, '/');
        if (!empty($this->version)) {
            $path = '/' . trim($this->version) . $path;
        }
        Router::addRoute(RequestMethod::REQUEST_HEAD, $path, [$controller, $method]);
    }


}
