<?php
declare(strict_types=1);

namespace Kiri\Router\Validator;

use Exception;
use Kiri\Di\Inject\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 *
 */
class ValidatorMiddleware implements MiddlewareInterface
{


    public Validator $validator;


    /**
     * @var ResponseInterface
     */
    #[Container(ResponseInterface::class)]
    public ResponseInterface $response;


    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws Exception
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->validator->run($request)) {
            return $this->response->html($this->validator->error(), 415);
        } else {
            return $handler->handle($request);
        }
    }
}
