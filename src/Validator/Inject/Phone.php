<?php

namespace Kiri\Inject\Validator\Inject;

use Exception;
use Kiri\Inject\Route\LocalService;
use ReflectionException;
use Kiri\Inject\Route\Container;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Phone implements ValidatorInterface
{
	const REG = '/^1[356789]\d{9}$/';

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
			$data = $service->post($name, null);
		} else {
			$data = $service->query($name, null);
		}
		return preg_match(self::REG, $data);
	}
}
