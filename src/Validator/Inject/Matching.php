<?php

namespace Kiri\Router\Validator\Inject;


use Kiri\Router\Interface\ValidatorInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Matching implements ValidatorInterface
{


    /**
     * @param string $value
     */
    public function __construct(readonly public string $value)
    {
    }


    /**
     * @param mixed $data
     * @param object $class
     * @return bool
     */
    public function dispatch(mixed $data, object $class): bool
    {
        if ($data !== null) {
            return preg_match('/' . preg_quote($this->value) . '/', $data);
        } else {
            return false;
        }
    }
}