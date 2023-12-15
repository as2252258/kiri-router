<?php
namespace Kiri\Router\Validator\Types;



class BoolProxy extends TypesProxy
{


    /**
     * @param object $form
     * @param mixed $value
     * @return bool
     */
    public function dispatch(object $form, string $field, mixed $value): bool
    {
        // TODO: Implement dispatch() method.
        if (in_array($value, ['false', 'true'])) {
            $form->{$field} = $value === 'true';
        } else if (in_array($value, ['0', '1'])) {
            $form->{$field} = $value === '1';
        } else {
            return false;
        }
        return true;
    }

}