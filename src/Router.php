<?php
declare(strict_types=1);

namespace Kiri\Router;

use Closure;
use Exception;
use Kiri;
use Kiri\Router\Base\Middleware as MiddlewareManager;
use Kiri\Router\Constrict\RequestMethod;
use Kiri\Server\Events\OnWorkerStart;
use ReflectionException;

/**
 *
 *
 * $component->set([
 *  'request' => [
 *      'middlewares' => []
 *  ]
 * ])
 */
class Router
{


    const METHODS = [RequestMethod::REQUEST_POST, RequestMethod::REQUEST_GET, RequestMethod::REQUEST_OPTIONS, RequestMethod::REQUEST_DELETE, RequestMethod::REQUEST_PUT, RequestMethod::REQUEST_HEAD];


    /**
     * @var string
     */
    private static string $type = ROUTER_TYPE_HTTP;


    /**
     * @param string $name
     * @param Closure $closure
     */
    public static function addServer(string $name, Closure $closure): void
    {
        static::$type = $name;
        $closure();
        static::$type = ROUTER_TYPE_HTTP;
    }


    /**
     * @param Closure $handler
     */
    public static function jsonp(Closure $handler): void
    {
        static::$type = 'json-rpc';
        $handler();
        static::$type = ROUTER_TYPE_HTTP;
    }


    /**
     * @param string $route
     * @param string $handler
     * @throws ReflectionException
     */
    public static function post(string $route, string $handler): void
    {
        $router = Kiri::getDi()->get(DataGrip::class)->get(static::$type);
        $router->addRoute([RequestMethod::REQUEST_POST], $route, $handler);
    }

    /**
     * @param string $route
     * @param string $handler
     * @throws ReflectionException
     */
    public static function get(string $route, string $handler): void
    {
        $router = Kiri::getDi()->get(DataGrip::class)->get(static::$type);
        $router->addRoute([RequestMethod::REQUEST_GET], $route, $handler);
    }


    /**
     * @param string $route
     * @param string $handler
     * @throws
     */
    public static function options(string $route, string $handler): void
    {
        $router = Kiri::getDi()->get(DataGrip::class)->get(static::$type);
        $router->addRoute([RequestMethod::REQUEST_OPTIONS], $route, $handler);
    }


    /**
     * @param string $route
     * @param string $handler
     * @throws
     */
    public static function any(string $route, string $handler): void
    {
        $router = Kiri::getDi()->get(DataGrip::class)->get(static::$type);
        $router->addRoute(self::METHODS, $route, $handler);
    }

    /**
     * @param string $route
     * @param string $handler
     * @throws ReflectionException
     */
    public static function delete(string $route, string $handler): void
    {
        $router = Kiri::getDi()->get(DataGrip::class)->get(static::$type);
        $router->addRoute([RequestMethod::REQUEST_DELETE], $route, $handler);
    }


    /**
     * @param string $route
     * @param string $handler
     * @throws ReflectionException
     */
    public static function head(string $route, string $handler): void
    {
        $router = Kiri::getDi()->get(DataGrip::class)->get(static::$type);
        $router->addRoute([RequestMethod::REQUEST_HEAD], $route, $handler);
    }


    /**
     * @param string $route
     * @param string $handler
     * @throws ReflectionException
     */
    public static function put(string $route, string $handler): void
    {
        $router = Kiri::getDi()->get(DataGrip::class)->get(static::$type);
        $router->addRoute([RequestMethod::REQUEST_PUT], $route, $handler);
    }


    /**
     * @param array|RequestMethod $methods
     * @param string $route
     * @param array|string $handler
     * @throws ReflectionException
     */
    public static function addRoute(array|RequestMethod $methods, string $route, array|string $handler): void
    {
        $router = Kiri::getDi()->get(DataGrip::class)->get(static::$type);
        if ($methods instanceof RequestMethod) {
            $methods = [$methods];
        }
        $router->addRoute($methods, $route, $handler);
    }


    /**
     * @param array $config
     * @param Closure $closure
     * @throws
     */
    public static function group(array $config, Closure $closure): void
    {
        $router = Kiri::getDi()->get(DataGrip::class)->get(static::$type);

        $router->groupTack[] = $config;

        call_user_func($closure);

        array_pop($router->groupTack);
    }


    /**
     * @throws
     */
    public function scan_build_route(): void
    {
        $scanner = Kiri::getDi()->get(Kiri\Di\Scanner::class);
        $scanner->read(APP_PATH . 'app/');
        $scanner->parse('App');

        $this->read_dir_file(APP_PATH . 'routes');
        $this->reset();
    }


    /**
     * @return void
     * @throws ReflectionException
     */
    public function reset(): void
    {
        $router     = Kiri::getDi()->get(DataGrip::class)->get(static::$type);
        $middleware = \Kiri::getDi()->get(MiddlewareManager::class);
        foreach ($router->getMethods() as $name => $method) {
            $middlewares = $middleware->get($method->getClass(), $method->getMethod());

            $router->setMethod($name, new HttpRequestHandler($middlewares, $method));
        }
    }


    /**
     * @param $path
     * @return void
     * @throws Exception
     */
    private function read_dir_file($path): void
    {
        $files = glob($path . '/*');
        for ($i = 0; $i < count($files); $i++) {
            $file = $files[$i];
            if (is_dir($file)) {
                $this->read_dir_file($file);
            } else {
                $this->resolve_file($file);
            }
        }
    }


    /**
     * @param $files
     * @throws Exception
     */
    private function resolve_file($files): void
    {
        try {
            include "$files";
        } catch (\Throwable $throwable) {
            error($throwable);
        }
    }

}
