<?php

namespace Kiri\Inject\Validator\Inject;

use Exception;
use Kiri\Inject\Route\LocalService;
use ReflectionException;
use Kiri\Inject\Route\Container;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Email implements ValidatorInterface
{


	/**
	 * @return string
	 */
	public function getError(): string
	{
		return '';
	}


	/**
	 * @param string $name
	 * @return bool
	 * @throws ReflectionException
	 * @throws Exception
	 */
	public function dispatch(string $name): bool
	{
		// TODO: Implement dispatch() method.
		$service = Container::getContext()->get(LocalService::class)->get('request');
		if ($service->isPost) {
			return filter_var($service->post($name, null), FILTER_VALIDATE_EMAIL);
		} else {
			return filter_var($service->query($name, null), FILTER_VALIDATE_EMAIL);
		}
	}
}
