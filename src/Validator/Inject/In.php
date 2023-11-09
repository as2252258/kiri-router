<?php
declare(strict_types=1);

namespace Kiri\Router\Validator\Inject;

use Kiri\Router\Interface\ValidatorInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class In implements ValidatorInterface
{


    /**
	 * @param array $value
	 */
	public function __construct(readonly public array $value)
	{
	}


    /**
     * @param mixed $data
     * @param object $class
     * @return bool
     */
    public function dispatch(mixed $data, object $class): bool
    {
        if ($data === null) {
            return false;
        }
		return in_array($data, $this->value);
	}
}
