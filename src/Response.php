<?php
declare(strict_types=1);

namespace Kiri\Router;

use Kiri\Di\Interface\ResponseEmitterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;


/**
 *
 */
class Response implements ResponseInterface
{


    /**
     * @var ContentType
     */
    public ContentType $contentType = ContentType::JSON;


    /**
     * @var string|ResponseEmitterInterface
     */
    public string|ResponseEmitterInterface $emmit = SwooleHttpResponseEmitter::class;


    /**
     * 初始化
     */
    public function __construct()
    {
        $this->contentType = \config('response.content-type', ContentType::JSON);
        $this->emmit       = \config('response.emmit', SwooleHttpResponseEmitter::class);
    }

    /**
     * @return void
     * @throws
     */
    public function init(): void
    {
        if (is_string($this->emmit)) {
            $this->emmit = di($this->emmit);
        }
    }


    /**
     * @param ContentType $contentType
     * @return Response
     */
    public function withContentType(ContentType $contentType): ResponseInterface
    {
        return $this->__call__(__FUNCTION__, $contentType);
    }


    /**
     * @param array $content
     * @param int $statusCode
     * @return ResponseInterface
     */
    public function json(array $content, int $statusCode = 200): ResponseInterface
    {
        return $this->__call__(__FUNCTION__, $content, $statusCode);
    }


    /**
     * @param array $content
     * @param int $statusCode
     * @return ResponseInterface
     */
    public function xml(array $content, int $statusCode = 200): ResponseInterface
    {
        return $this->__call__(__FUNCTION__, $content, $statusCode);
    }


    /**
     * @param string $content
     * @param int $statusCode
     * @return ResponseInterface
     */
    public function html(string $content = '', int $statusCode = 200): ResponseInterface
    {
        return $this->__call__(__FUNCTION__, $content, $statusCode);
    }


    /**
     * @param string $content
     * @param int $statusCode
     * @return ResponseInterface
     */
    public function sendfile(string $content, int $statusCode = 200): ResponseInterface
    {
        return $this->__call__(__FUNCTION__, $content, $statusCode);
    }


    /**
     * @param mixed $data
     * @param int $statusCode
     * @param ContentType $type
     * @return Response
     */
    public function write(mixed $data, int $statusCode = 200, ContentType $type = ContentType::HTML): ResponseInterface
    {
        return $this->__call__(__FUNCTION__, $data, $statusCode, $type);
    }


    /**
     * @param string $method
     * @param mixed ...$params
     * @return mixed
     */
    private function __call__(string $method, ...$params): mixed
    {
        return \response()->{$method}(...$params);
    }


    /**
     * @param array $cookies
     * @return ResponseInterface
     */
    public function withCookieParams(array $cookies): ResponseInterface
    {
        return $this->__call__(__FUNCTION__, $cookies);
    }


    /**
     * @return array
     */
    public function getCookieParams(): array
    {
        return $this->__call__(__FUNCTION__);
    }


    /**
     * Retrieves the HTTP protocol version as a string.
     *
     * The string MUST contain only the HTTP version number (e.g., "1.1", "1.0").
     *
     * @return string HTTP protocol version.
     */
    public function getProtocolVersion(): string
    {
        // TODO: Implement getProtocolVersion() method.
        return $this->__call__(__FUNCTION__);
    }

    /**
     * Return an instance with the specified HTTP protocol version.
     *
     * The version string MUST contain only the HTTP version number (e.g.,
     * "1.1", "1.0").
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new protocol version.
     *
     * @param string $version HTTP protocol version
     * @return static
     */
    public function withProtocolVersion(string $version): ResponseInterface
    {
        // TODO: Implement withProtocolVersion() method.
        return $this->__call__(__FUNCTION__, $version);
    }

    /**
     * Retrieves all message header values.
     *
     * The keys represent the header name as it will be sent over the wire, and
     * each value is an array of strings associated with the header.
     *
     *     // Represent the headers as a string
     *     foreach ($message->getHeaders() as $name => $values) {
     *         echo $name . ": " . implode(", ", $values);
     *     }
     *
     *     // Emit headers iteratively:
     *     foreach ($message->getHeaders() as $name => $values) {
     *         foreach ($values as $value) {
     *             header(sprintf('%s: %s', $name, $value), false);
     *         }
     *     }
     *
     * While header names are not case-sensitive, getHeaders() will preserve the
     * exact case in which headers were originally specified.
     *
     * @return string[][] Returns an associative array of the message's headers. Each
     *     key MUST be a header name, and each value MUST be an array of strings
     *     for that header.
     */
    public function getHeaders(): array
    {
        // TODO: Implement getHeaders() method.
        return $this->__call__(__FUNCTION__);
    }

    /**
     * Checks if a header exists by the given case-insensitive name.
     *
     * @param string $name Case-insensitive header field name.
     * @return bool Returns true if any header names match the given header
     *     name using a case-insensitive string comparison. Returns false if
     *     no matching header name is found in the message.
     */
    public function hasHeader(string $name): bool
    {
        // TODO: Implement hasHeader() method.
        return $this->__call__(__FUNCTION__, $name);
    }

    /**
     * Retrieves a message header value by the given case-insensitive name.
     *
     * This method returns an array of all the header values of the given
     * case-insensitive header name.
     *
     * If the header does not appear in the message, this method MUST return an
     * empty array.
     *
     * @param string $name Case-insensitive header field name.
     * @return string[] An array of string values as provided for the given
     *    header. If the header does not appear in the message, this method MUST
     *    return an empty array.
     */
    public function getHeader(string $name): array
    {
        // TODO: Implement getHeader() method.
        return $this->__call__(__FUNCTION__, $name);
    }

    /**
     * Retrieves a comma-separated string of the values for a single header.
     *
     * This method returns all the header values of the given
     * case-insensitive header name as a string concatenated together using
     * a comma.
     *
     * NOTE: Not all header values may be appropriately represented using
     * comma concatenation. For such headers, use getHeader() instead
     * and supply your own delimiter when concatenating.
     *
     * If the header does not appear in the message, this method MUST return
     * an empty string.
     *
     * @param string $name Case-insensitive header field name.
     * @return string A string of values as provided for the given header
     *    concatenated together using a comma. If the header does not appear in
     *    the message, this method MUST return an empty string.
     */
    public function getHeaderLine(string $name): string
    {
        // TODO: Implement getHeaderLine() method.
        return $this->__call__(__FUNCTION__, $name);
    }

    /**
     * Return an instance with the provided value replacing the specified header.
     *
     * While header names are case-insensitive, the casing of the header will
     * be preserved by this function, and returned from getHeaders().
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new and/or updated header and value.
     *
     * @param string $name Case-insensitive header field name.
     * @param string|string[] $value Header value(s).
     * @return static
     * @throws
     */
    public function withHeader(string $name, $value): ResponseInterface
    {
        // TODO: Implement withHeader() method.
        return $this->__call__(__FUNCTION__, $name, $value);
    }


    /**
     * @param array $headers
     * @return ResponseInterface
     */
    public function withHeaders(array $headers): ResponseInterface
    {
        return $this->__call__(__FUNCTION__, $headers);
    }

    /**
     * Return an instance with the specified header appended with the given value.
     *
     * Existing values for the specified header will be maintained. The new
     * value(s) will be appended to the existing list. If the header did not
     * exist previously, it will be added.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new header and/or value.
     *
     * @param string $name Case-insensitive header field name to add.
     * @param string|string[] $value Header value(s).
     * @return static
     * @throws
     */
    public function withAddedHeader(string $name, $value): ResponseInterface
    {
        // TODO: Implement withAddedHeader() method.
        return $this->__call__(__FUNCTION__, $name, $value);
    }

    /**
     * Return an instance without the specified header.
     *
     * Header resolution MUST be done without case-sensitivity.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that removes
     * the named header.
     *
     * @param string $name Case-insensitive header field name to remove.
     * @return static
     */
    public function withoutHeader(string $name): ResponseInterface
    {
        // TODO: Implement withoutHeader() method.
        return $this->__call__(__FUNCTION__, $name);
    }

    /**
     * Gets the body of the message.
     *
     * @return StreamInterface Returns the body as a stream.
     */
    public function getBody(): StreamInterface
    {
        // TODO: Implement getBody() method.
        return $this->__call__(__FUNCTION__);
    }

    /**
     * Return an instance with the specified message body.
     *
     * The body MUST be a StreamInterface object.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return a new instance that has the
     * new body stream.
     *
     * @param StreamInterface $body Body.
     * @return static
     * @throws
     */
    public function withBody(StreamInterface $body): ResponseInterface
    {
        // TODO: Implement withBody() method.
        return $this->__call__(__FUNCTION__, $body);
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
        return $this->__call__(__FUNCTION__);
    }


    /**
     * @param string $content
     * @param int $statusCode
     * @param ContentType $contentType
     * @return ResponseInterface
     */
    public function raw(string $content, int $statusCode = 200, ContentType $contentType = ContentType::JSON): ResponseInterface
    {
        return $this->__call__(__FUNCTION__, $content, $statusCode, $contentType);
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
    public function withStatus(int $code, string $reasonPhrase = ''): ResponseInterface
    {
        // TODO: Implement withStatus() method.
        return $this->__call__(__FUNCTION__, $code, $reasonPhrase);
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
        return $this->__call__(__FUNCTION__);
    }
}
