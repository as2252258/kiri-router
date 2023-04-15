<?php

namespace Kiri\Router\Interface;

interface ValidatorInterface
{


	public function dispatch(object $class, string $name): bool;

}
