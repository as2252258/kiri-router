<?php
declare(strict_types=1);

namespace Kiri\Router\Constrict;

use Kiri\Core\Help;
use Kiri\Router\ContentType;
use Kiri\Router\StreamResponse;
use Psr\Http\Message\ResponseInterface;

class ConstrictResponse extends Message implements ResponseInterface
{


    private int $code = 200;


    private string $reasonPhrase;


    /**
     * @param ContentType|null $contentType
     */
    public function __construct(?ContentType $contentType = null)
    {
        if ($contentType != null) {
            $this->withHeader('Content-Type', $contentType->toString());
        }
        parent::__construct();
    }


    /**
     * @param ContentType $contentType
     * @return $this
     */
    public function withContentType(ContentType $contentType): static
    {
        $this->withHeader('Content-Type', $contentType->toString());
        return $this;
    }


    /**
     * @param mixed $data
     * @param int $statusCode
     * @param ContentType $type
     * @return $this
     */
    public function write(mixed $data, int $statusCode = 200, ContentType $type = ContentType::HTML): static
    {
        if ($data instanceof \Stringable) {
            $this->stream->write($data->__toString());
        } else {
            $this->stream->write((string)$data);
        }
        return $this->withContentType($type)->withStatus($statusCode);
    }


    /**
     * @param mixed $content
     * @param int $statusCode
     * @return $this
     */
    public function xml(array $content, int $statusCode = 200): static
    {
        $this->stream->write(Help::toXml($content));
        return $this->withContentType(ContentType::XML)->withStatus($statusCode);
    }


    /**
     * @param array $content
     * @param int $statusCode
     * @return $this
     */
    public function json(array $content, int $statusCode = 200): static
    {
        $this->stream->write(json_encode($content, JSON_UNESCAPED_UNICODE));
        return $this->withContentType(ContentType::JSON)->withStatus($statusCode);
    }


    /**
     * @param string $content
     * @param int $statusCode
     * @param ContentType $contentType
     * @return $this
     */
    public function raw(string $content, int $statusCode = 200, ContentType $contentType = ContentType::JSON): static
    {
        $this->stream->write($content);
        return $this->withContentType($contentType)->withStatus($statusCode);
    }


    /**
     * @param string $content
     * @param int $statusCode
     * @return $this
     */
    public function html(string $content = '', int $statusCode = 200): static
    {
        $this->stream->write($content);
        return $this->withContentType(ContentType::HTML)->withStatus($statusCode);
    }


    /**
     * @param string $content
     * @param int $statusCode
     * @return $this
     */
    public function sendfile(string $content, int $statusCode = 200): ResponseInterface
    {
        $stream = new StreamResponse();
        $stream->withBody(new Stream(fopen($content, 'r+')));
        return $stream->withStatus($statusCode);
    }

    /**
     * Gets the response status code.
     *
     * The status code is a 3-digit integer result code of the server's attempt
     * to understand and satisfy the request.
     *
     * @return int Status code.
     */
    public function getStatusCode(): int
    {
        // TODO: Implement getStatusCode() method.
        return $this->code;
    }

    /**
     * Return an instance with the specified status code and, optionally, reason phrase.
     *
     * If no reason phrase is specified, implementations MAY choose to default
     * to the RFC 7231 or IANA recommended reason phrase for the response's
     * status code.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated status and reason phrase.
     *
     * @link http://tools.ietf.org/html/rfc7231#section-6
     * @link http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     * @param int $code The 3-digit integer result code to set.
     * @param string $reasonPhrase The reason phrase to use with the
     *     provided status code; if none is provided, implementations MAY
     *     use the defaults as suggested in the HTTP specification.
     * @return static
     * @throws
     */
    public function withStatus(int $code, string $reasonPhrase = ''): static
    {
        // TODO: Implement withStatus() method.
        $this->code         = $code;
        $this->reasonPhrase = $reasonPhrase;
        return $this;
    }

    /**
     * Gets the response reason phrase associated with the status code.
     *
     * Because a reason phrase is not a required element in a response
     * status line, the reason phrase value MAY be null. Implementations MAY
     * choose to return the default RFC 7231 recommended reason phrase (or those
     * listed in the IANA HTTP Status Code Registry) for the response's
     * status code.
     *
     * @link http://tools.ietf.org/html/rfc7231#section-6
     * @link http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     * @return string Reason phrase; must return an empty string if none present.
     */
    public function getReasonPhrase(): string
    {
        // TODO: Implement getReasonPhrase() method.
        return $this->reasonPhrase;
    }


    /**
     * @param object $response
     * @return void
     */
    public function end(object $response): void
    {
        $response->end($this->stream->getContents());
    }
}
