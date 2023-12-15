<?php

namespace Kiri\Router\Validator\Types;

class FloatProxy extends TypesProxy
{


    /**
     * @param object $form
     * @param mixed $value
     * @return bool
     */
    public function dispatch(object $form, string $field, mixed $value): bool
    {
        return $value == ($form->{$field} = (float)$value);
    }
}