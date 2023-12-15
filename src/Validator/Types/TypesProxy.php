<?php

namespace Kiri\Router\Validator\Types;

abstract class TypesProxy
{


    /**
     * @var bool
     */
    public bool $allowsNull = false;


    /**
     * @param object $form
     * @param string $field
     * @param mixed $value
     * @return bool
     */
    abstract public function dispatch(object $form, string $field, mixed $value): bool;

}