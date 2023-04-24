<?php
declare(strict_types=1);

namespace Kiri\Router;


use Exception;
use Kiri;
use Kiri\Di\Interface\ResponseEmitterInterface;
use Kiri\Router\Base\Middleware as MiddlewareManager;
use Kiri\Router\Interface\ExceptionHandlerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Kiri\Di\Inject\Service;
use Kiri\Router\Constrict\ConstrictResponse;
use Kiri\Router\Base\ExceptionHandlerDispatcher;


/**
 *
 */
class ServerRequest
{


	/**
	 * @var RouterCollector
	 */
	public RouterCollector $router;


	/**
	 * @var ExceptionHandlerInterface
	 */
	public ExceptionHandlerInterface $exception;


	/**
	 * @var ResponseEmitterInterface
	 */
	public ResponseEmitterInterface $emitter;


	/**
	 * @var Request
	 */
	#[Service('request')]
	public RequestInterface $request;


	/**
	 * @throws Exception
	 */
	public function init(): void
	{
		$container = Kiri::getDi();
		$exception = $this->request->exception;
		if (!in_array(ExceptionHandlerInterface::class, class_implements($exception))) {
			$exception = ExceptionHandlerDispatcher::class;
		}
		$this->exception = $container->get($exception);
		$this->router = $container->get(DataGrip::class)->get(ROUTER_TYPE_HTTP);

		$this->emitter = Kiri::service()->get('response')->emmit;
	}


	/**
	 * @param ServerRequestInterface $request
	 * @param object $response
	 * @return void
	 * @throws
	 */
	public function onServerRequest(ServerRequestInterface $request, object $response): void
	{
		try {
			$request_uri = $request->getMethod() == 'OPTIONS' ? '/*' : $request->getUri()->getPath();
			$dispatcher = $this->router->query($request_uri, $request->getMethod());

			$middleware = [];
			if (!($dispatcher instanceof Kiri\Router\Base\NotFoundController)) {
				$middlewareManager = \Kiri::getDi()->get(MiddlewareManager::class);

				$middleware = $middlewareManager->get($dispatcher->getClass(), $dispatcher->getMethod());
			}

			$PsrResponse = (new HttpRequestHandler($middleware, $dispatcher))->handle($request);
		} catch (\Throwable $throwable) {
			error($throwable);
			$PsrResponse = $this->exception->emit($throwable, di(ConstrictResponse::class));
		} finally {
			$this->emitter->sender($PsrResponse, $response);
		}
	}

}
