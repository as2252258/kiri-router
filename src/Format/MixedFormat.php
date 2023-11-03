<?php

namespace Kiri\Router\Format;

use Kiri\Di\Inject\Container;
use Kiri\Router\Constrict\Stream;
use Kiri\Router\ContentType;
use Psr\Http\Message\ResponseInterface;

class MixedFormat implements IFormat
{

    /**
     * @var ResponseInterface
     */
    #[Container(ResponseInterface::class)]
    public ResponseInterface $response;



    /**
     * @param mixed $result
     * @return ResponseInterface
     */
    public function call(mixed $result): ResponseInterface
    {
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