<?php

namespace Kiri\Router\Validator\RequestFilter;

abstract class ValidatorFilter
{


    /**
     * @var mixed
     */
    public mixed $value;


    /**
     * @var string
     */
    public string $field;


    /**
     * @param mixed $value
     * @return bool
     */
    abstract public function dispatch(mixed $value): bool;


}