<?php
declare(strict_types=1);

namespace Kiri\Router\Validator\Inject;

use Kiri\Router\Interface\ValidatorInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Ignore implements ValidatorInterface
{


    /**
     * @param mixed $data
     * @param object $class
     * @return bool
     */
	public function dispatch(mixed $data, object $class): bool
	{
		return true;
	}
}
