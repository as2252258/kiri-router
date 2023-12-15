<?php

namespace Kiri\Router\Validator\RequestFilter;

class MustValidatorFilter extends ValidatorFilter
{

    /**
     * @param mixed $value
     * @return bool
     */
    public function dispatch(mixed $value): bool
    {
        return $value === $this->value;
    }

}