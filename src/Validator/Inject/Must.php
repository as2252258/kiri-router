<?php
declare(strict_types=1);

namespace Kiri\Router\Validator\Inject;


use Kiri\Router\Interface\ValidatorInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Must implements ValidatorInterface
{

    /**
     * @param mixed $value
     */
    public function __construct(readonly public mixed $value)
    {
    }


    /**
     * @param mixed $data
     * @param object $class
     * @return bool
     */
    public function dispatch(mixed $data, object $class): bool
    {
        return $data === $this->value;
    }

}
