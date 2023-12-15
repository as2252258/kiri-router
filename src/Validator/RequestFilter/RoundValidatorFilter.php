<?php

namespace Kiri\Router\Validator\RequestFilter;

class RoundValidatorFilter extends ValidatorFilter
{

    /**
     * @param mixed $value
     * @return bool
     */
    public function dispatch(mixed $value): bool
    {
        return round((float)$value, $this->value) === $value;
    }

}