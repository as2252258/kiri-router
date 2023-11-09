<?php
declare(strict_types=1);

namespace Kiri\Router\Validator\Inject;

use Kiri\Router\Interface\ValidatorInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Email implements ValidatorInterface
{


    /**
     * @return string
     */
    public function getError(): string
    {
        return '';
    }


    /**
     * @param mixed $data
     * @param object $class
     * @return bool
     */
    public function dispatch(mixed $data, object $class): bool
    {
        if ($data === null) {
            return false;
        }
        return filter_var($data, FILTER_VALIDATE_EMAIL);
    }
}
