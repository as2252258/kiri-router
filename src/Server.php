<?php
declare(strict_types=1);

namespace Kiri\Router;


use Exception;
use Kiri;
use Kiri\Router\Base\Middleware as MiddlewareManager;
use Psr\Container\ContainerInterface;
use Kiri\Di\Context;
use Kiri\Events\EventProvider;
use Kiri\Router\Interface\ExceptionHandlerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Swoole\Http\Request;
use Kiri\Di\Inject\Service;
use Swoole\Http\Response;
use Kiri\Di\Inject\Container;
use Kiri\Router\Constrict\ConstrictRequest;
use Kiri\Router\Constrict\ConstrictResponse;
use Kiri\Router\Constrict\Uri;
use Kiri\Router\Interface\OnRequestInterface;
use Kiri\Router\Base\ExceptionHandlerDispatcher;


/**
 *
 */
class Server implements OnRequestInterface
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
	 * @var \Kiri\Router\Request
	 */
	#[Service('request')]
	public RequestInterface $request;


	/**
	 * @var \Kiri\Router\Response
	 */
	#[Service('response')]
	public ResponseInterface $response;


	/**
	 * @throws Exception
	 */
	public function init(): void
	{
		$this->emitter = di(HttpResponseEmitter::class);

		$exception = $this->request->exception;
		if (!in_array(ExceptionHandlerInterface::class, class_implements($exception))) {
			$exception = ExceptionHandlerDispatcher::class;
		}
		$this->exception = di($exception);

		$this->router = di(DataGrip::class)->get(ROUTER_TYPE_HTTP);
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

			$request_uri = $request->getMethod() == 'OPTIONS' ? '/*' : $request->server['request_uri'];
			$dispatcher = $this->router->query($request_uri, $request->getMethod());

			$middleware = [];
			if (!($dispatcher instanceof Kiri\Router\Base\NotFoundController)) {
				$middlewareManager = \Kiri::getDi()->get(MiddlewareManager::class);

				$middleware = $middlewareManager->get($dispatcher->getClass(), $dispatcher->getMethod());
			}

			$PsrResponse = (new HttpRequestHandler($middleware, $dispatcher))->handle($PsrRequest);
		} catch (\Throwable $throwable) {
			error($throwable);
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
		/** @var ConstrictResponse $PsrResponse */
		$PsrResponse = Context::set(ResponseInterface::class, new ConstrictResponse());
		$PsrResponse->withContentType($this->response->contentType);

		$serverRequest = (new ConstrictRequest())->withDataHeaders($request->getData())
			->withUri(Uri::parse($request))
			->withProtocolVersion($request->server['server_protocol'])
			->withCookieParams($request->cookie ?? [])
			->withQueryParams($request->get ?? [])
			->withUploadedFiles($request->files ?? [])
			->withMethod($request->getMethod())
			->withParsedBody($request->post ?? []);

		/** @var ConstrictRequest $PsrRequest */
		return Context::set(RequestInterface::class, $serverRequest);
	}


}
