<?php
declare(strict_types=1);

namespace Kiri\Router\Interface;

interface ValidatorInterface
{


    /**
     * @param mixed $data
     * @param object $class
     * @return bool
     */
	public function dispatch(mixed $data, object $class): bool;

}
