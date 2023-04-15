<?php

namespace Kiri\Router\Validator\Inject;

interface ValidatorInterface
{


	public function dispatch(object $class, string $name): bool;

}
