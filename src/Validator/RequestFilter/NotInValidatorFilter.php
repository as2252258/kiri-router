<?php

namespace Kiri\Router\Validator\RequestFilter;

class NotInValidatorFilter extends ValidatorFilter
{

    /**
     * @param mixed $value
     * @return bool
     */
    public function dispatch(mixed $value): bool
    {
        return !in_array($value, $this->value);
    }

}