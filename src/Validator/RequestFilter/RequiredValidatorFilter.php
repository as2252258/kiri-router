<?php

namespace Kiri\Router\Validator\RequestFilter;

class RequiredValidatorFilter extends ValidatorFilter
{


    /**
     * @param mixed $value
     * @return bool
     */
    public function dispatch(mixed $value): bool
    {
        return true;
    }


}