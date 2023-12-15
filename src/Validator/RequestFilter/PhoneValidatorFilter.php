<?php
declare(strict_types=1);

namespace Kiri\Router\Validator\RequestFilter;


class PhoneValidatorFilter extends ValidatorFilter
{
    const string REG = '/^1[356789]\d{9}$/';


    /**
     * @param mixed $value
     * @return bool
     */
    public function dispatch(mixed $value): bool
    {
        return preg_match(self::REG, $value);
    }
}
