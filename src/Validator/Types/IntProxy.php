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
        if (is_null($value)) {
            if (!$this->allowsNull) {
                return false;
            }
            $form->{$field} = 0;
            return false;
        }
        return $value == ($form->{$field} = (int)$value);
    }

}