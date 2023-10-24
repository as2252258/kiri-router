<?php
declare(strict_types=1);

namespace Kiri\Router\Interface;

interface ValidatorInterface
{


    /**
     * @param object $class
     * @param string $name
     * @return bool
     */
	public function dispatch(object $class, string $name): bool;

}
