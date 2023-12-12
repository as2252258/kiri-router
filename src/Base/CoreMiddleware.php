<?php
declare(strict_types=1);

namespace Kiri\Router\Base;

use Kiri\Di\Inject\Container;
use Kiri\Router\Request;
use Kiri\Router\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 *
 */
class CoreMiddleware implements MiddlewareInterface
{


    /**
     * @var Response
     */
    #[Container(ResponseInterface::class)]
    public ResponseInterface $response;


    /**
     * @param Request $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->response->withHeaders(['Access-Control-Allow-Headers' => '*', 'Access-Control-Request-Method' => '*', 'Access-Control-Allow-Origin' => '*']);
        return $handler->handle($request);
    }

}
