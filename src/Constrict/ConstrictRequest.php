<?php
declare(strict_types=1);

namespace Kiri\Router\Constrict;

use JetBrains\PhpStorm\ArrayShape;
use Kiri\Core\Xml;
use Kiri\Router\Base\AuthorizationInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Swoole\Http\Request;

class ConstrictRequest extends Message implements RequestInterface, ServerRequestInterface
{


    /**
     * @var string
     */
    private string $method;


    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var array|object|null
     */
    private array|null|object $parsedBody = null;

    private array $files        = [];
    private array $queryParams  = [];
    private array $serverParams = [];
    private array $_attributes  = [];


    /**
     * @var AuthorizationInterface|null
     */
    private ?AuthorizationInterface $authorization = null;

    /**
     * @return AuthorizationInterface|null
     */
    public function getAuthority(): ?AuthorizationInterface
    {
        return $this->authorization;
    }


    /**
     * @param AuthorizationInterface $authorization
     * @return RequestInterface
     */
    public function withAuthority(AuthorizationInterface $authorization): RequestInterface
    {
        $this->authorization = $authorization;
        return $this;
    }


    /**
     * @param string $name
     * @return File|null
     */
    public function file(string $name): ?File
    {
        if (isset($this->files[$name])) {
            return new File($this->files[$name]);
        } else {
            return null;
        }
    }


    /**
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->method === 'POST';
    }


    /**
     * Retrieves the message's request target.
     *
     * Retrieves the message's request-target either as it will appear (for
     * clients), as it appeared at request (for servers), or as it was
     * specified for the instance (see withRequestTarget()).
     *
     * In most cases, this will be the origin-form of the composed URI,
     * unless a value was provided to the concrete implementation (see
     * withRequestTarget() below).
     *
     * If no URI is available, and no request-target has been specifically
     * provided, this method MUST return the string "/".
     *
     * @return string
     */
    public function getRequestTarget(): string
    {
        // TODO: Implement getRequestTarget() method.
        return (string)$this->getUri();
    }


    /**
     * @param array $headers
     * @return $this
     */
    public function withHeaders(array $headers): static
    {
        foreach ($headers as $key => $header) {
            $this->withHeader($key, [$header]);
        }
        return $this;
    }


    /**
     * @param string $data
     * @return ConstrictRequest
     */
    public function withDataHeaders(string $data): static
    {
        $headers = explode("\r\n\r\n", $data);
        $headers = explode("\r\n", $headers[0]);
        foreach ($headers as $header) {
            $keyValue = explode(': ', $header);
            if (!isset($keyValue[1])) {
                $keyValue[1] = '';
            }
            $keyValue[1] = explode(', ', $keyValue[1]);
            $this->withHeader(...$keyValue);
        }
        return $this;
    }

    /**
     * Return an instance with the specific request-target.
     *
     * If the request needs a non-origin-form request-target — e.g., for
     * specifying an absolute-form, authority-form, or asterisk-form —
     * this method may be used to create an instance with the specified
     * request-target, verbatim.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request target.
     *
     * @link http://tools.ietf.org/html/rfc7230#section-5.3 (for the various
     *     request-target forms allowed in request messages)
     * @param string $requestTarget
     * @return static
     */
    public function withRequestTarget(string $requestTarget): static
    {
        // TODO: Implement withRequestTarget() method.
        return $this;
    }

    /**
     * Retrieves the HTTP method of the request.
     *
     * @return string Returns the request method.
     */
    public function getMethod(): string
    {
        // TODO: Implement getMethod() method.
        return $this->method;
    }

    /**
     * Return an instance with the provided HTTP method.
     *
     * While HTTP method names are typically all uppercase characters, HTTP
     * method names are case-sensitive and thus implementations SHOULD NOT
     * modify the given string.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request method.
     *
     * @param string $method Case-sensitive method.
     * @return static
     * @throws
     */
    public function withMethod(string $method): static
    {
        // TODO: Implement withMethod() method.
        $this->method = $method;
        return $this;
    }

    /**
     * Retrieves the URI instance.
     *
     * This method MUST return a UriInterface instance.
     *
     * @link http://tools.ietf.org/html/rfc3986#section-4.3
     * @return UriInterface Returns a UriInterface instance
     *     representing the URI of the request.
     */
    public function getUri(): UriInterface
    {
        // TODO: Implement getUri() method.
        return $this->uri;
    }

    /**
     * Returns an instance with the provided URI.
     *
     * This method MUST update the Host header of the returned request by
     * default if the URI contains a host component. If the URI does not
     * contain a host component, any pre-existing Host header MUST be carried
     * over to the returned request.
     *
     * You can opt-in to preserving the original state of the Host header by
     * setting `$preserveHost` to `true`. When `$preserveHost` is set to
     * `true`, this method interacts with the Host header in the following ways:
     *
     * - If the Host header is missing or empty, and the new URI contains
     *   a host component, this method MUST update the Host header in the returned
     *   request.
     * - If the Host header is missing or empty, and the new URI does not contain a
     *   host component, this method MUST NOT update the Host header in the returned
     *   request.
     * - If a Host header is present and non-empty, this method MUST NOT update
     *   the Host header in the returned request.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new UriInterface instance.
     *
     * @link http://tools.ietf.org/html/rfc3986#section-4.3
     * @param UriInterface $uri New request URI to use.
     * @param bool $preserveHost Preserve the original state of the Host header.
     * @return static
     */
    public function withUri(UriInterface $uri, bool $preserveHost = false): static
    {
        // TODO: Implement withUri() method.
        $this->uri = $uri;
        return $this;
    }

    /**
     * Retrieve server parameters.
     *
     * Retrieves data related to the incoming request environment,
     * typically derived from PHP's $_SERVER superglobal. The data IS NOT
     * REQUIRED to originate from $_SERVER.
     *
     * @return array
     */
    public function getServerParams(): array
    {
        // TODO: Implement getServerParams() method.
        return $this->serverParams;
    }


    /**
     * @param string $key
     * @return string|int|float|null
     */
    public function getServerParam(string $key): string|int|float|null
    {
        return $this->serverParams[$key] ?? null;
    }


    /**
     * Return an instance with the specified cookies.
     *
     * The data IS NOT REQUIRED to come from the $_COOKIE superglobal, but MUST
     * be compatible with the structure of $_COOKIE. Typically, this data will
     * be injected at instantiation.
     *
     * This method MUST NOT update the related Cookie header of the request
     * instance, nor related values in the server params.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated cookie values.
     *
     * @param array $cookies Array of key/value pairs representing cookies.
     * @return static
     */
    public function withServerParams(array $cookies): static
    {
        // TODO: Implement withCookieParams() method.
        $this->serverParams = $cookies;
        return $this;
    }

    /**
     * Retrieve query string arguments.
     *
     * Retrieves the deserialized query string arguments, if any.
     *
     * Note: the query params might not be in sync with the URI or server
     * params. If you need to ensure you are only getting the original
     * values, you may need to parse the query string from `getUri()->getQuery()`
     * or from the `QUERY_STRING` server param.
     *
     * @return array
     */
    public function getQueryParams(): array
    {
        // TODO: Implement getQueryParams() method.
        return $this->queryParams;
    }

    /**
     * Return an instance with the specified query string arguments.
     *
     * These values SHOULD remain immutable over the course of the incoming
     * request. They MAY be injected during instantiation, such as from PHP's
     * $_GET superglobal, or MAY be derived from some other value such as the
     * URI. In cases where the arguments are parsed from the URI, the data
     * MUST be compatible with what PHP's parse_str() would return for
     * purposes of how duplicate query parameters are handled, and how nested
     * sets are handled.
     *
     * Setting query string arguments MUST NOT change the URI stored by the
     * request, nor the values in the server params.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated query string arguments.
     *
     * @param array $query Array of query string arguments, typically from
     *     $_GET.
     * @return static
     */
    public function withQueryParams(array $query): static
    {
        // TODO: Implement withQueryParams() method.
        $this->queryParams = $query;
        return $this;
    }

    /**
     * Retrieve normalized file upload data.
     *
     * This method returns upload metadata in a normalized tree, with each leaf
     * an instance of Psr\Http\Message\UploadedFileInterface.
     *
     * These values MAY be prepared from $_FILES or the message body during
     * instantiation, or MAY be injected via withUploadedFiles().
     *
     * @return array An array tree of UploadedFileInterface instances; an empty
     *     array MUST be returned if no data is present.
     */
    public function getUploadedFiles(): array
    {
        // TODO: Implement getUploadedFiles() method.
        return $this->files;
    }

    /**
     * Create a new instance with the specified uploaded files.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated body parameters.
     *
     * @param array $uploadedFiles An array tree of UploadedFileInterface instances.
     * @return static
     * @throws
     */
    public function withUploadedFiles(array $uploadedFiles): static
    {
        // TODO: Implement withUploadedFiles() method.
        $this->files = $uploadedFiles;
        return $this;
    }

    /**
     * Retrieve any parameters provided in the request body.
     *
     * If the request Content-Type is either application/x-www-form-urlencoded
     * or multipart/form-data, and the request method is POST, this method MUST
     * return the contents of $_POST.
     *
     * Otherwise, this method may return any results of deserializing
     * the request body content; as parsing returns structured content, the
     * potential types MUST be arrays or objects only. A null value indicates
     * the absence of body content.
     *
     * @return null|array|object The deserialized body parameters, if any.
     *     These will typically be an array or object.
     */
    public function getParsedBody(): object|array|null
    {
        // TODO: Implement getParsedBody() method.
        if ($this->parsedBody instanceof \Closure) {
            $this->parsedBody = call_user_func($this->parsedBody, $this->getBody()->getContents());
        }
        return $this->parsedBody;
    }

    /**
     * Return an instance with the specified body parameters.
     *
     * These MAY be injected during instantiation.
     *
     * If the request Content-Type is either application/x-www-form-urlencoded
     * or multipart/form-data, and the request method is POST, use this method
     * ONLY to inject the contents of $_POST.
     *
     * The data IS NOT REQUIRED to come from $_POST, but MUST be the results of
     * deserializing the request body content. Deserialization/parsing returns
     * structured data, and, as such, this method ONLY accepts arrays or objects,
     * or a null value if nothing was available to parse.
     *
     * As an example, if content negotiation determines that the request data
     * is a JSON payload, this method could be used to create a request
     * instance with the deserialized parameters.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated body parameters.
     *
     * @param null|array|object|Request $data The deserialized body data. This will
     *     typically be in an array or object.
     * @return static
     * @throws
     *     provided.
     */
    public function withParsedBody($data): static
    {
        $contentType      = $data->header['content-type'] ?? 'application/json';
        $post             = $data->post;
        $this->parsedBody = static function (string $content) use ($contentType, $post) {
            if (\str_contains($contentType, 'json')) {
                return \json_decode($content, true);
            } else if (\str_contains($contentType, 'xml')) {
                return Xml::toArray($content);
            } else {
                return $post ?? [];
            }
        };
        return $this;
    }

    /**
     * Retrieve attributes derived from the request.
     *
     * The request "attributes" may be used to allow injection of any
     * parameters derived from the request: e.g., the results of path
     * match operations; the results of decrypting cookies; the results of
     * deserializing non-form-encoded message bodies; etc. Attributes
     * will be application and request specific, and CAN be mutable.
     *
     * @return array Attributes derived from the request.
     */
    public function getAttributes(): array
    {
        // TODO: Implement getAttributes() method.
        return $this->_attributes;
    }

    /**
     * Retrieve a single derived request attribute.
     *
     * Retrieves a single derived request attribute as described in
     * getAttributes(). If the attribute has not been previously set, returns
     * the default value as provided.
     *
     * This method obviates the need for a hasAttribute() method, as it allows
     * specifying a default value to return if the attribute is not found.
     *
     * @param string $name The attribute name.
     * @param mixed $default Default value to return if the attribute does not exist.
     * @return mixed
     * @see getAttributes()
     */
    public function getAttribute(string $name, $default = null): mixed
    {
        // TODO: Implement getAttribute() method.
        return $this->_attributes[$name] ?? $default;
    }

    /**
     * Return an instance with the specified derived request attribute.
     *
     * This method allows setting a single derived request attribute as
     * described in getAttributes().
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated attribute.
     *
     * @param string $name The attribute name.
     * @param mixed $value The value of the attribute.
     * @return static
     * @see getAttributes()
     */
    public function withAttribute(string $name, $value): static
    {
        // TODO: Implement withAttribute() method.
        $this->_attributes[$name] = $value;
        return $this;
    }

    /**
     * Return an instance that removes the specified derived request attribute.
     *
     * This method allows removing a single derived request attribute as
     * described in getAttributes().
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that removes
     * the attribute.
     *
     * @param string $name The attribute name.
     * @return static
     * @see getAttributes()
     */
    public function withoutAttribute(string $name): static
    {
        // TODO: Implement withoutAttribute() method.
        unset($this->_attributes[$name]);
        return $this;
    }


    /**
     * @return int
     */
    public function offset(): int
    {
        $params = $this->getQueryParams();
        $page   = (int)($params['page'] ?? 1);
        $size   = $this->size();
        if ($page < 1) {
            $page = 1;
        }
        return ($page - 1) * $size;
    }


    /**
     * page slice num
     *
     * @return int
     */
    public function size(): int
    {
        $params = $this->getQueryParams();
        $size   = (int)($params['size'] ?? 1);
        if ($size < 1) {
            $size = 1;
        }
        return $size;
    }


    /**
     * @param Request $request
     * @return static
     */
    public static function builder(Request $request): static
    {
        $static = (new static())->withUri(new Uri($request));
        $static->withHeaders($request->header ?? []);
        $static->withProtocolVersion($request->server['server_protocol']);
        $static->withCookieParams($request->cookie ?? []);
        $static->withServerParams($request->server);
        $static->withQueryParams($request->get ?? []);
        $static->withBody(new Stream($request->getContent()));
        $static->withParsedBody($request);
        $static->withUploadedFiles($request->files ?? []);
        $static->withMethod($request->getMethod());
        return $static;
    }
}
