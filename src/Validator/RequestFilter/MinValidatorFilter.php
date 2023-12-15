<?php

namespace Kiri\Router\Validator\RequestFilter;

class MinValidatorFilter extends ValidatorFilter
{

    /**
     * @param mixed $value
     * @return bool
     */
    public function dispatch(mixed $value): bool
    {
        return (float)$value >= $this->value;
    }

}