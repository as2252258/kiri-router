<?php

namespace Kiri\Router\Format;

use Kiri\Di\Inject\Container;
use Kiri\Router\Constrict\Stream;
use Kiri\Router\ContentType;
use Psr\Http\Message\ResponseInterface;

class NoBody implements IFormat
{


    /**
     * @var ResponseInterface
     */
    #[Container(ResponseInterface::class)]
    public ResponseInterface $response;


    /**
     * @param $result
     * @return ResponseInterface
     */
    public function call($result): ResponseInterface
    {
        // TODO: Implement call() method.
        if (request()->getMethod() === 'HEAD') {
            return $this->response->withBody(new Stream());
        }
        if ($result instanceof ResponseInterface) {
            return $result;
        }
        if (is_object($result)) {
            return $this->response->withBody(new Stream('[object]'));
        }
        if (is_array($result)) {
            return $this->response->withContentType(ContentType::JSON)->withBody(new Stream(json_encode($result, JSON_UNESCAPED_UNICODE)));
        } else {
            return $this->response->withBody(new Stream((string)$result));
        }
    }
}