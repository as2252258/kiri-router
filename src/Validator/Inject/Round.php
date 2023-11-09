<?php
declare(strict_types=1);

namespace Kiri\Router\Validator\Inject;

use Kiri\Router\Interface\ValidatorInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Round implements ValidatorInterface
{


	/**
	 * @param int $value
	 */
	public function __construct(readonly public int $value)
	{
	}


    /**
     * @param mixed $data
     * @param object $class
     * @return bool
     */
    public function dispatch(mixed $data, object $class): bool
    {
		return round($data, $this->value) === $data;
	}
}
