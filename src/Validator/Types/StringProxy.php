<?php

namespace Kiri\Router\Validator\Types;


class StringProxy extends TypesProxy
{


    /**
     * @param object $form
     * @param string $field
     * @param mixed $value
     * @return bool
     */
    public function dispatch(object $form, string $field, mixed $value): bool
    {
        return $value == ($form->{$field} = (string)$value);
    }

}