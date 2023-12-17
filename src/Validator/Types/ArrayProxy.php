<?php

namespace Kiri\Router\Validator\Types;


class ArrayProxy extends TypesProxy
{


    /**
     * @param object $form
     * @param string $field
     * @param mixed $value
     * @return bool
     */
    public function dispatch(object $form, string $field, mixed $value): bool
    {
        if (is_null($value)) {
            if (!$this->allowsNull) {
                return false;
            }
            $form->{$field} = [];
            return true;
        }
        return $value == ($form->{$field} = $value);
    }

}