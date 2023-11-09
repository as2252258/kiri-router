<?php
declare(strict_types=1);

namespace Kiri\Router\Validator\Inject;

use Kiri\Router\Interface\ValidatorInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Phone implements ValidatorInterface
{
    const REG = '/^1[356789]\d{9}$/';


    /**
     * @param mixed $data
     * @param object $class
     * @return bool
     */
    public function dispatch(mixed $data, object $class): bool
    {
        if ($data == null || !is_numeric($data)) {
            return false;
        }
        return preg_match(self::REG, $data);
    }
}
