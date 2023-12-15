<?php

namespace Kiri\Router\Validator\RequestFilter;

class MaxLengthValidatorFilter extends ValidatorFilter
{

    /**
     * @param mixed $value
     * @return bool
     */
    public function dispatch(mixed $value): bool
    {
        if (is_array($value)) {
            return count($value) <= $this->value;
        }
        return mb_strlen((string)$value) <= $this->value;
    }

}