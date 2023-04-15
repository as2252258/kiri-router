<?php
declare(strict_types=1);

namespace Kiri\Router;


use Exception;
use Kiri;
use Kiri\Abstracts\AbstractServer;
use Kiri\Di\ContainerInterface;
use Kiri\Di\Context;
use Kiri\Events\EventProvider;
use Kiri\Router\Interface\ExceptionHandlerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Kiri\Router\Constrict\ConstrictRequest;
use Kiri\Router\Constrict\ConstrictResponse;
use Kiri\Router\Constrict\Uri;
use Kiri\Router\Interface\OnRequestInterface;
use Kiri\Router\Base\ExceptionHandlerDispatcher;


/**
 *
 */
class Server extends AbstractServer implements OnRequestInterface
{

	public RouterCollector $router;


	/**
	 * @var ExceptionHandlerInterface
	 */
	public ExceptionHandlerInterface $exception;

	/**
	 * @var HttpResponseEmitter
	 */
	public HttpResponseEmitter $emitter;


	/**
	 * @param ContainerInterface $container
	 * @param EventProvider $provider
	 * @param array $config
	 * @throws Exception
	 */
	public function __construct(
		public ContainerInterface $container,
		public EventProvider      $provider,
		array                     $config = [])
	{
		parent::__construct($config);
	}


	/**
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 * @throws Exception
	 */
	public function init()
	{
		$this->emitter = $this->container->get(HttpResponseEmitter::class);

		$exception = Kiri::service()->get('request')->exception;
		if (!in_array(ExceptionHandlerInterface::class, class_implements($exception))) {
			$exception = ExceptionHandlerDispatcher::class;
		}
		$this->exception = $this->container->get($exception);

		$this->router = $this->container->get(DataGrip::class)->get(ROUTER_TYPE_HTTP);
	}


	/**
	 * @param Request $request
	 * @param Response $response
	 * @throws Exception
	 */
	public function onRequest(Request $request, Response $response): void
	{
		try {
			/** @var ConstrictRequest $PsrRequest */
			$PsrRequest = $this->initRequestAndResponse($request);

			$dispatcher = $this->router->query($request->server['request_uri'], $request->getMethod());

			$PsrResponse = (new HttpRequestHandler([], $dispatcher))->handle($PsrRequest);
		} catch (\Throwable $throwable) {
			$this->logger->error($throwable->getMessage(), [$throwable]);
			$PsrResponse = $this->exception->emit($throwable, di(ConstrictResponse::class));
		} finally {
			$this->emitter->sender($PsrResponse, $response);
		}
	}


	/**
	 * @param Request $request
	 * @return RequestInterface
	 * @throws Exception
	 */
	private function initRequestAndResponse(Request $request): RequestInterface
	{
		/** @var \Kiri\Router\Response $response */
		$response = Kiri::service()->get('response');

		/** @var ConstrictResponse $PsrResponse */
		$PsrResponse = Context::set(ResponseInterface::class, new ConstrictResponse());
		$PsrResponse->withContentType($response->contentType);

		$serverRequest = (new ConstrictRequest())->withDataHeaders($request->getData())
			->withUri(Uri::parse($request))
			->withProtocolVersion($request->server['server_protocol'])
			->withCookieParams($request->cookie ?? [])
			->withQueryParams($request->get)
			->withUploadedFiles($request->files)
			->withMethod($request->getMethod())
			->withParsedBody($request->post);

		/** @var ConstrictRequest $PsrRequest */
		return Context::set(RequestInterface::class, $serverRequest);
	}


}
