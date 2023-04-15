<?php
declare(strict_types=1);

namespace Kiri\Router\Constrict;

use Kiri\Router\ContentType;
use Psr\Http\Message\ResponseInterface;

class ConstrictResponse extends Message implements ResponseInterface
{


	private int $code = 200;


	private string $reasonPhrase;
	private array $cookieParams;


	/**
	 * @param ContentType $type
	 * @return $this
	 */
	public function withContentType(ContentType $type): static
	{
		$this->withHeader('Content-Type', $type->name);
		return $this;
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
	 * @throws \InvalidArgumentException For invalid status code arguments.
	 */
	public function withStatus(int $code, string $reasonPhrase = ''): static
	{
		// TODO: Implement withStatus() method.
		$this->code = $code;
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
	 * @param array $cookies
	 * @return ResponseInterface
	 */
	public function withCookieParams(array $cookies): static
	{
		$this->cookieParams = $cookies;
		return $this;
	}


	/**
	 * @return array
	 */
	public function getCookieParams(): array
	{
		return $this->cookieParams;
	}



	/**
	 * @param object $response
	 * @return void
	 */
	public function write(object $response): void
	{
		$response->end($this->getBody()->getContents());
	}
}
