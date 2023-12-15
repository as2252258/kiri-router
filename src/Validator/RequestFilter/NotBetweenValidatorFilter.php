<?php

namespace Kiri\Router\Validator\RequestFilter;

class NotBetweenValidatorFilter extends ValidatorFilter
{

    /**
     * @param mixed $value
     * @return bool
     */
    public function dispatch(mixed $value): bool
    {
        [$min, $max] = $this->value;
        
        return $value <= $min || $value >= $max;
    }

}