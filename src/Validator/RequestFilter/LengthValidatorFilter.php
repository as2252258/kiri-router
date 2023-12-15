<?php

namespace Kiri\Router\Validator\RequestFilter;

class LengthValidatorFilter extends ValidatorFilter
{

    /**
     * @param mixed $value
     * @return bool
     */
    public function dispatch(mixed $value): bool
    {
        return mb_strlen((string)$value) === $this->value;
    }

}