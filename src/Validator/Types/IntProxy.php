<?php

namespace Kiri\Router\Validator\Types;

class IntProxy extends TypesProxy
{


    /**
     * @param object $form
     * @param string $field
     * @param mixed $value
     * @return bool
     */
    public function dispatch(object $form, string $field, mixed $value): bool
    {
        return $value == ($form->{$field} = (int)$value);
    }

}