<?php

namespace Kiri\Router\Validator\RequestFilter;

use function Symfony\Component\String\s;

class EmailValidatorFilter extends ValidatorFilter
{


    /**
     * @param mixed $value
     * @return bool
     */
    public function dispatch(mixed $value): bool
    {
        return filter_var((string)$value, FILTER_VALIDATE_EMAIL);
    }

}