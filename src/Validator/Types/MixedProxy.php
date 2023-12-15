<?php

namespace Kiri\Router\Validator\Types;


class MixedProxy extends TypesProxy
{


    public array $types = [];


    /**
     * @param object $form
     * @param string $field
     * @param mixed $value
     * @return bool
     */
    public function dispatch(object $form, string $field, mixed $value): bool
    {
        try {
            return $value == ($form->{$field} = $value);
        } catch (\Throwable $throwable) {
            return false;
        }
    }

}